package moocs;

/**
 * Created by Tang on 3/30/14.
 */
public class UdacityCourseInstructor {
    private String name;
    private String title;
    private String biography;
    private String imageUrl;

    public UdacityCourseInstructor(String name, String title, String biography, String imageUrl) {
        this.name = name;
        this.title = title;
        this.biography = biography;
        this.imageUrl = imageUrl;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getBiography() {
        return biography;
    }

    public void setBiography(String biography) {
        this.biography = biography;
    }

    public String getImageUrl() {
        return imageUrl;
    }

    public void setImageUrl(String imageUrl) {
        this.imageUrl = imageUrl;
    }

    public String toString() {
        StringBuilder builder = new StringBuilder();

        builder.append("Instructor Name: ").append(name).append("\n")
               .append("Title: ").append(title).append("\n")
               .append("Biography: ").append(biography).append("\n")
               .append("Image: ").append(imageUrl).append("\n");

        return builder.toString();
    }
}
