package moocs;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by Tang on 3/31/14.
 */
public class UdacityCourse {
    private String id;
    private String title;
    private String shortDescription;
    private String longDescription;
    private String imageUrl;
    private String courseUrl;
    private double price;
    private String priceInterval;
    private List<UdacityCourseInstructor> instructors;

    public UdacityCourse() {
        instructors = new ArrayList<UdacityCourseInstructor>();
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getShortDescription() {
        return shortDescription;
    }

    public void setShortDescription(String shortDescription) {
        this.shortDescription = shortDescription;
    }

    public String getLongDescription() {
        return longDescription;
    }

    public void setLongDescription(String longDescription) {
        this.longDescription = longDescription;
    }

    public String getImageUrl() {
        return imageUrl;
    }

    public void setImageUrl(String imageUrl) {
        this.imageUrl = imageUrl;
    }

    public String getCourseUrl() {
        return courseUrl;
    }

    public void setCourseUrl(String courseUrl) {
        this.courseUrl = courseUrl;
    }

    public double getPrice() {
        return price;
    }

    public void setPrice(double price) {
        this.price = price;
    }

    public String getPriceInterval() {
        return priceInterval;
    }

    public void setPriceInterval(String priceInterval) {
        this.priceInterval = priceInterval;
    }

    public List<UdacityCourseInstructor> getInstructors() {
        return instructors;
    }

    public void addInstructor(UdacityCourseInstructor instructor) {
        instructors.add(instructor);
    }

    public String toString() {
        StringBuilder builder = new StringBuilder();

        builder.append("Course ID: ").append(id).append("\n")
               .append("Course Title: ").append(title).append("\n")
               .append("Short Description: ").append(shortDescription).append("\n")
               .append("Long Description: ").append(longDescription).append("\n")
               .append("Image URL: ").append(imageUrl).append("\n")
               .append("Course URL: ").append(courseUrl).append("\n")
               .append("Price: ");

        if (price > 0) {
            builder.append("$").append(price).append("\n")
                   .append("Price Interval: per ").append(priceInterval).append("\n\n");
        }
        else {
            builder.append("Free").append("\n")
                   .append("Price Interval: Free").append("\n\n");
        }

        for (UdacityCourseInstructor instructor : instructors) {
            builder.append(instructor).append("\n");
        }

        return builder.toString();
    }
}
