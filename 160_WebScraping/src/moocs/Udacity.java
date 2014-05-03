package moocs;

import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;
import com.google.gson.stream.JsonReader;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.StringTokenizer;

/*

Cloud MySQL Login Information

mysql://bd887ba87d4a49:93a9097d@us-cdbr-east-05.cleardb.net/heroku_229e6c24d3396ae

Host: us-cdbr-east-05.cleardb.net
Username: bd887ba87d4a49
Password: 93a9097d
Database Name: heroku_229e6c24d3396ae

 */

public class Udacity {
    //TODO: JSON_DATA should be removed from this class and placed in an outside class that combines both MOOCs.
    public static String JSON_DATA = "https://www.udacity.com/api/nodes?depth=2&fresh=false&keys%5B%5D=course_catalog&projection=catalog&required_behavior=find";
    public static String BASE_COURSE_URL = "https://www.udacity.com/course/";

    // These are only use in the JSON file
    public static String TITLE_KEY = "title";
    public static String SUBTITLE_KEY = "subtitle";
    public static String CATALOG_KEY = "catalog_entry";
    public static String DESCRIPTION_KEY = "short_summary";
    public static String IMAGE_KEY = "_image";
    public static String IMAGE_URL_KEY = "serving_url";

    private String url;
    private static java.sql.Connection connection;
    private int id = 62;
    private int course_id = 34;
    
    public Udacity(String url) {
        this.url = url;
    }

    public void parse() throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
        try {
            List<UdacityCourse> courses = new ArrayList<UdacityCourse>();
            InputStream stream = new URL(url).openStream();
            stream.skip(4); // Udacity has garbage in first line of JSON

            JsonReader reader = new JsonReader(new InputStreamReader(stream));
            JsonParser parser = new JsonParser();
            JsonElement element = parser.parse(reader);
            JsonObject object = element.getAsJsonObject();

            object = object.get("references").getAsJsonObject(); // Get JSON data inside "references"
            object = object.get("Node").getAsJsonObject(); // Get JSON data inside "references['Node']"

            for (Map.Entry entry : object.entrySet()) {
                String courseId = (String) entry.getKey();
                JsonElement courseElement = (JsonElement) entry.getValue();
                JsonObject courseObject = courseElement.getAsJsonObject();
                JsonElement courseTitle = courseObject.get(TITLE_KEY);
                JsonElement courseCatalog = courseObject.get(CATALOG_KEY);
                
                if (courseCatalog != null && courseCatalog.isJsonObject()) {
                    UdacityCourse course = new UdacityCourse();
                    JsonElement courseSubtitle = courseCatalog.getAsJsonObject().get(SUBTITLE_KEY);
                    JsonElement shortCourseDescription = courseCatalog.getAsJsonObject().get(DESCRIPTION_KEY);
                    JsonElement courseImage = courseCatalog.getAsJsonObject().get(IMAGE_KEY)
                                                           .getAsJsonObject().get(IMAGE_URL_KEY);
                    course.setId(courseId);
                    course.setTitle(courseTitle.getAsString());
                    course.setSubtitle(courseSubtitle.getAsString());
                    course.setShortDescription(shortCourseDescription.getAsString());
                    course.setImageUrl("https://" + courseImage.getAsString().substring(2));
                    course.setCourseUrl(BASE_COURSE_URL + courseId);

                    getAdditionalCourseData(course);
                    courses.add(course);

                    //Print out for debugging
                    System.out.println(course);
                    Statement statement = connection.createStatement();
                    System.out.println(course.getInsertionQuery());
                    statement.executeUpdate(course.getInsertionQuery());
                    ArrayList<String> instrqueries = course.getInstructorQueries(id, course_id);
                    for (String instrquery : instrqueries)
                    {
                       System.out.println(instrquery);
                       statement.executeUpdate(instrquery);
                       id++;
                    }
                    statement.close();
                    course_id++;
                }
            }

            reader.close();
        }
        catch (IOException ex) {
            ex.printStackTrace();
        }
    }

    private void getAdditionalCourseData(UdacityCourse course) {
        try {
            Document doc = Jsoup.connect(course.getCourseUrl()).get();
            doc.outputSettings().charset("UTF-16");
            Elements instructorElements = doc.select(".instructor-information-entry");
            Elements instructorNames = instructorElements.select("h3");
            Elements instructorTitles = instructorElements.select("h4");
            Elements instructorBiographies = instructorElements.select(".pretty-format p");
            Elements instructorImageUrls = instructorElements.select("img");
            Elements coursePrice = doc.select(".actual-price");
            Elements courseCategory = doc.select(".text-large a");

            // Get price and price interval
            if (!coursePrice.isEmpty()) {
                Elements coursePriceInterval = doc.select(".subscription-interval");
                course.setPrice(Double.parseDouble(coursePrice.html().substring(1)));
                course.setPriceInterval(coursePriceInterval.html().substring(1));
            }

            // Store category
            course.setCategory(courseCategory.html());

            // Get long course description
            Elements h2Elements = doc.select("h2");

            for (Element element : h2Elements) {
                if ("Course Summary".equals(element.html())) {
                    course.setLongDescription(Jsoup.parse(element.nextElementSibling().select("p").html()).text());
                }
            }

            // Store instructor information
            for (int i = 0; i < instructorTitles.size(); i++) {
                course.addInstructor(new UdacityCourseInstructor(
                    instructorNames.get(i).html(),
                    instructorTitles.get(i).html(),
                    instructorBiographies.get(i).html(),
                    "https://" + imageUrlExtractor(instructorImageUrls.get(i).attr("data-ng-src")))
                );
            }

            // Store university if there is one
            if (instructorNames.size() > instructorTitles.size()) { // The extra name is the University
                course.setOrganization(instructorNames.get(instructorNames.size() - 1).html());
            }
        }
        catch (IOException e) {
            e.printStackTrace();
        }
    }

    private String imageUrlExtractor(String attributeValue) {
        String delimeters = "'";
        StringTokenizer tokenizer = new StringTokenizer(attributeValue, delimeters);

        tokenizer.nextToken(); // Skip to middle token
        return tokenizer.nextToken().substring(2); // Skip the first two //
    }

    public static void main(String [] args) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException{
        Udacity udacity = new Udacity(JSON_DATA);
        Class.forName("com.mysql.jdbc.Driver").newInstance();
        connection = DriverManager.getConnection("jdbc:mysql://localhost/novoed_udacity?useUnicode=true&amp;characterEncoding=UTF-16","root","novacity");

        udacity.parse();
    }
}
