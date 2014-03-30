package moocs;

import com.google.gson.JsonElement;
import com.google.gson.JsonObject;
import com.google.gson.JsonParser;
import com.google.gson.stream.JsonReader;

import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.URL;
import java.util.Map;
import java.util.Set;

//TODO: I have only parsed out the title and description for now. I found out there is no date for Udacity. There seem to be
//TODO: very few related fields. Feel free to add stuff.

public class Udacity {
    //TODO: JSON_DATA will be the URL passed into the constructor in the future
    public static String JSON_DATA = "https://www.udacity.com/api/nodes?depth=2&fresh=false&keys%5B%5D=course_catalog&projection=catalog&required_behavior=find";

    public static String TITLE_KEY = "title";
    public static String CATALOG_KEY = "catalog_entry";
    public static String DESCRIPTION_KEY = "short_summary";

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

            element = object.get("references"); // Get JSON data inside "references"
            object = element.getAsJsonObject();
            element = object.get("Node"); // Get JSON data inside "references['Node']"
            object = element.getAsJsonObject();

            Set<Map.Entry<String, JsonElement>> dataSet = object.entrySet();

            for (Map.Entry entry : dataSet) {
                JsonElement courseElement = (JsonElement) entry.getValue();
                JsonObject courseObject = courseElement.getAsJsonObject();
                JsonElement courseTitle = courseObject.get(TITLE_KEY);

                JsonElement courseCatalog = courseObject.get(CATALOG_KEY);
                JsonElement courseDescription = null;

                if (courseCatalog != null && courseCatalog.isJsonObject()) {
                    courseDescription = courseCatalog.getAsJsonObject().get(DESCRIPTION_KEY);

                    // Print our for debugging
                    System.out.println(courseTitle);
                    System.out.println(courseDescription + "\n");
                }
            }
        }
        catch (IOException ex) {
            ex.printStackTrace();
        }
    }

    public static void main(String [] args) {
        Udacity udacity = new Udacity(JSON_DATA);
        udacity.parse();
    }
}
