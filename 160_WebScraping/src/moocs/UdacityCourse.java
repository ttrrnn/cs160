package moocs;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

/**
 * Created by Tang on 3/31/14.
 */
public class UdacityCourse {
    private String id;
    private String title;
    private String subtitle;
    private String category;
    private String shortDescription;
    private String longDescription;
    private String imageUrl;
    private String courseUrl;
    private double price;
    private String priceInterval;
    private String organization;
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

    public String getSubtitle() {
        return subtitle;
    }

    public void setSubtitle(String subtitle) {
        this.subtitle = subtitle;
    }

    public String getCategory() {
        return category;
    }

    public void setCategory(String category) {
        this.category = category;
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

    public String getOrganization() {
        return organization;
    }

    public void setOrganization(String organization) {
        this.organization = organization;
    }

    public List<UdacityCourseInstructor> getInstructors() {
        return instructors;
    }

    public void addInstructor(UdacityCourseInstructor instructor) {
        instructors.add(instructor);
    }

    public String getInsertionQuery() {

       // For Date parsed
       Calendar cal = Calendar.getInstance();
       cal.add(Calendar.DATE, 1);
       SimpleDateFormat format1 = new SimpleDateFormat("yyyy-MM-dd");
       String dscrap = format1.format(cal.getTime());
       if (!(category == null))
          category = category.replace('\n', ' ');
       shortDescription = shortDescription.replace("'", "''");
       shortDescription = shortDescription.replace(",", "");
       longDescription = shortDescription.replace("'", "''");
       longDescription = shortDescription.replace(",", "");

       return "insert into course_data values(null,'"+title+"','"+shortDescription+"','"+longDescription+"','"+courseUrl+"','','"+dscrap+"', 0,'"+imageUrl+"','"+category+"','Udacity','"+(int) price+"','English', 'No','"+organization+"','"+dscrap+"')";
    }
    
    public ArrayList<String> getInstructorQueries(int id, int course_id) {
       ArrayList<String> instrqueries = new ArrayList<String>();
       
       for (UdacityCourseInstructor instructor : instructors)
       {
          instrqueries.add(instructor.getInsertionQuery(id, course_id));
          id++;
       }
       return instrqueries;
    }
    
    public String toString() {
        StringBuilder builder = new StringBuilder();

        builder.append("Course ID: ").append(id).append("\n")
               .append("Course Title: ").append(title).append("\n")
               .append("Course Subtitle: ").append(subtitle).append("\n")
               .append("Organization: ").append(organization).append("\n")
               .append("Category: ").append(category).append("\n")
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
