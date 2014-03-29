package moocs;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.select.Elements;
import org.jsoup.nodes.Element;
import java.sql.*;
import java.io.IOException;
import java.util.ArrayList;

public class Novoed {
	
	/**
	 * @param args
	 * @throws IOException 
	 * @throws ClassNotFoundException 
	 * @throws IllegalAccessException 
	 * @throws InstantiationException 
	 * @throws SQLException 
	 */
	public static void main(String[] args) throws IOException, InstantiationException, IllegalAccessException, ClassNotFoundException, SQLException {
		// Need Jsoup jar files to run this sample program. You may also need to rebuild path, etc.

		/*
		ArrayList<String> month = new ArrayList<String>();
		month.add("January"); month.add("February"); month.add("March"); month.add("April"); month.add("May"); month.add("June"); 
		month.add("July"); month.add("August"); month.add("September"); month.add("October"); month.add("November"); month.add("December"); 
		*/

		String url1 = "https://novoed.com/courses";
		 
		ArrayList<String> pgcrs = new ArrayList<String>(); //Array which will store each course URLs 
		pgcrs.add(url1);

		//The following few lines of code are used to connect to a database so the scraped course content can be stored.
		Class.forName("com.mysql.jdbc.Driver").newInstance();
		java.sql.Connection connection = DriverManager.getConnection("jdbc:mysql://localhost/scrapedcourse","root","");
		//make sure you create a database named scrapedcourse in your local mysql database before running this code
		//default mysql database in your local machine is ID:root with no password
		//you can download scrapecourse database template from your Canvas account->modules->Team Project area
		for(int a=0; a<pgcrs.size();a++)
		{
			String furl = (String) pgcrs.get(a);
			Document doc = Jsoup.connect(furl).get();
			Elements ele = doc.select("ul[class=accessible]");
			//System.out.println(ele); 
			Elements crspg = ele.select("div[class=hovered row-fluid");
			//System.out.println("CoursePage " +crspg);
			Elements link = crspg.select("h2[class=coursetitle]").select("a[href]");
			//System.out.println("Link: " +link);

			for (int j=0; j<link.size();j++)
			{
				Statement statement = connection.createStatement();
				
				String crsurl = link.get(j).attr("href"); // Get Course URL
				System.out.println(crsurl);
				String CourseName = crspg.select("h2").get(j).text(); //Get the Course Name from h2 Tag
				CourseName = CourseName.replace("'", "''");
				CourseName = CourseName.replace(",", "");
				String SCrsDesrpTemp = crspg.select("p[class=description]").get(j).text();
				//System.out.println("De " +SCrsDesrpTemp);
				SCrsDesrpTemp = SCrsDesrpTemp.replace("?", "");
				//String SCrsDesrp = SCrsDesrpTemp.substring(0, (SCrsDesrpTemp.length()-5)); //To get the course description and remove the extra characters at the end.
				SCrsDesrpTemp = SCrsDesrpTemp.replace("'", "''");
				SCrsDesrpTemp = SCrsDesrpTemp.replace(",", "");
				
				String CrsImg;
				if(a==0||a==1)
				{
					CrsImg  = ele.select("img[alt= ]").get(a).attr("src"); //To get the course image
				}
				else
				{
					CrsImg = ele.select("img[alt= ]").get(a).attr("src"); //To get the course image - FOR URL4
				}
				Document crsdoc = Jsoup.connect(crsurl).get();
				//System.out.println("Course Document: " +crsdoc);
				Elements crsheadele = crsdoc.select("header[class=row-fluid coursepage]");
				//System.out.println("Head Element: " + crsheadele);
				String youtube = crsheadele.select("div[class=span5 course-video]").select("iframe[title]").attr("src"); //Youtube link
				//System.out.println("YT: " + youtube);
				Elements crsbodyele = crsdoc.select("div[class=container main-container]");
				//System.out.println("Course Body: " +crsbodyele);
				String CrsDes = crsbodyele.select("article[class=span7]").text(); //Course Description Element
				CrsDes = CrsDes.replace("'", "''");
				CrsDes = CrsDes.replace(",", "");
				if(CrsDes.contains("?"))
				{
					CrsDes = CrsDes.replace("?", "");
				}
				
				//System.out.println("Course Description: " +CrsDes);
				String Date = crsdoc.select("div[class=timeline inline-block]").text();
				//System.out.println("Date: " +Date);
				String StrDate;
				//String datechk;
				String crsduration = "0";
				if (Date.contains("Starting Fall")) {
					StrDate = Date.substring(Date.indexOf("l ")+2, Date.length());
					StrDate = "September 1, " + StrDate;
					//System.out.println("Date: " +StrDate);
				} else if (Date.contains("Starting Spring")) {
					StrDate = Date.substring(Date.indexOf("l ")+2, Date.length());
					StrDate = "February 1, " + StrDate;
					//System.out.println("Date2: " +StrDate);
				} else if (Date.contains("Starting")){
					StrDate = Date.substring(Date.indexOf("g ")+2, Date.length());
					//System.out.println("Date3: " +StrDate);
				} else if (Date.contains("Registration closed")) {
					String tmp = " Registration closed";
					StrDate = Date.substring(0, (Date.length()-tmp.length()));
					//crsduration = "0";
					//System.out.println("Date5: " +StrDate);
				} else {
					StrDate = Date;
					//crsduration = Date;
					//System.out.println("Date4: " +Date);
				}
				
				
				//String StrDate = Date.substring(Date.indexOf(":")+1, Date.length()); //Start date after the :
				//String datechk = StrDate.substring(0, StrDate.indexOf(" "));
				/*
				if(!datechk.matches(".*\\d.*"))
				{
					if(StrDate.contains("n/a"))
					{
						StrDate = "write you own code";
					}
					else
					{
						StrDate = "write your own code";
					}
				}
				else
				{
					String date = StrDate.substring(0, StrDate.indexOf(" "));
					String month = StrDate.substring(StrDate.indexOf(" ")+1, StrDate.indexOf(" ")+4);
					String year = StrDate.substring(StrDate.length()-4,StrDate.length());
					StrDate = "write your own code";
				}
				Element chk = crsdoc.select("div[class=effort last]").first();
				Element crslenschk = crsdoc.select("div[class*=duration]").first();
				String crsduration;
				if (crslenschk==null)
				{
					crsduration = "0";
				}
				else if(StrDate.contains("n/a self-paced"))
				{
					crsduration = "0";
				}
				else
				{
					try{
						String crsdurationtmp = crsdoc.select("div[class*=duration]").text();
						int start = crsdurationtmp.indexOf(":")+1;
						int end = crsdurationtmp.indexOf((" "),crsdurationtmp.indexOf(":"));
						crsduration = crsdurationtmp.substring(start, end);
					}
					catch (Exception e)
					{
						crsduration ="0";
						System.out.println("Exception");
					}
				} */ 
				//The following is used to insert scraped data into your database table. Need to uncomment all database related code to run this.
				//String query = "insert into course_data values(null,'"+CourseName+"','"+SCrsDesrpTemp+"','"+CrsDes+"','"+crsurl+"','"+youtube+"','"+StrDate+"',"+crsduration+",'"+CrsImg+"','','NovoEd', 0, '', 'yes', 'university', '2014-03-24')";
				
				// this isn't the actual query string. I hardcoded some values to test to see if it would work
				// need to fix StrDate (convert to YYYY-MM-DD format)
				// need to scrape following: course_fee (int), language (text), certificate (yes/no), university (text), and time_scraped (date time)
				
				String query = "insert into course_data values(null,'"+CourseName+"','"+SCrsDesrpTemp+"','"+CrsDes+"','"+crsurl+"','"+youtube+"','2014-01-01',"+crsduration+",'"+CrsImg+"','','NovoEd', 0, '', 'yes', 'university', '2014-03-24')";
				System.out.println(query);   
				
				statement.executeUpdate(query); // skip writing to database; focus on data printout to a text file instead.
				statement.close();
			 }
		}
		connection.close();
	}
}
