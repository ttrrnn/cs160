package moocs;

import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;
import com.google.gson.stream.JsonReader;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.select.Elements;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;
import java.util.StringTokenizer;

//TODO: Need to add cost and category probably. Udacity doesn't have many categories. They refer to it as track.
//TODO: I'm not sure if subtitle is needed since NovoEd doesn't have one.

public class Udacity {
    //TODO: JSON_DATA should be removed from this class and placed in an outside class that combines both MOOCs.
    public static String JSON_DATA = "https://www.udacity.com/api/nodes?depth=2&fresh=false&keys%5B%5D=course_catalog&projection=catalog&required_behavior=find";
    public static String BASE_COURSE_URL = "https://www.udacity.com/course/";

    public static String TITLE_KEY = "title";
    public static String CATALOG_KEY = "catalog_entry";
    public static String DESCRIPTION_KEY = "short_summary";
    public static String IMAGE_KEY = "_image";
    public static String IMAGE_URL_KEY = "serving_url";

    private String url;

    public Udacity(String url) {
        this.url = url;
    }

    public void parse() {
        try {
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
                    JsonElement courseDescription = courseCatalog.getAsJsonObject().get(DESCRIPTION_KEY);
                    JsonElement courseImage = courseCatalog.getAsJsonObject().get(IMAGE_KEY)
                                                           .getAsJsonObject().get(IMAGE_URL_KEY);

                    String courseUrl = BASE_COURSE_URL + courseId;
                    List<UdacityCourseInstructor> instructors = getInstructors(courseUrl);

                    // Print out for debugging
                    System.out.println("Course ID: " + courseId);
                    System.out.println("Title: " + courseTitle.getAsString());
                    System.out.println("Description: " + courseDescription.getAsString());
                    System.out.println("Image URL: " + courseImage.getAsString().substring(2));
                    System.out.println("Course URL: " + courseUrl + "\n");

                    for (UdacityCourseInstructor instructor : instructors) {
                        System.out.println(instructor);
                    }
                }
            }

            reader.close();
        }
        catch (IOException ex) {
            ex.printStackTrace();
        }
    }

    private List<UdacityCourseInstructor> getInstructors(String courseUrl) {
        List<UdacityCourseInstructor> instructors = null;

        try {
            Document doc = Jsoup.connect(courseUrl).get();
            instructors = new ArrayList<UdacityCourseInstructor>();
            Elements instructorElements = doc.select(".instructor-information-entry");
            Elements instructorNames = instructorElements.select("h3");
            Elements instructorTitles = instructorElements.select("h4");
            Elements instructorBiographies = instructorElements.select(".pretty-format p");
            Elements instructorImageUrls = instructorElements.select("img");

            for (int i = 0; i < instructorNames.size(); i++) {
                instructors.add(new UdacityCourseInstructor (
                    instructorNames.get(i).html(),
                    instructorTitles.get(i).html(),
                    instructorBiographies.get(i).html(),
                    imageUrlExtractor(instructorImageUrls.get(i).attr("data-ng-src")))
                );
            }
        }
        catch (IOException e) {
            e.printStackTrace();
        }

        return instructors;
    }

    private String imageUrlExtractor(String attributeValue) {
        String delimeters = "'";
        StringTokenizer tokenizer = new StringTokenizer(attributeValue, delimeters);

        tokenizer.nextToken(); // Skip to middle token
        return tokenizer.nextToken().substring(2); // Skip the first two //
    }

    public static void main(String [] args) {
        Udacity udacity = new Udacity(JSON_DATA);
        udacity.parse();
    }
}
