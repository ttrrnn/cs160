import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;

import java.io.IOException;


public class Soup {
	
	public Soup() {
		Document doc = null;
		try {
			doc = Jsoup.connect("https://www.udacity.com/courses#!/Data%20Science").get();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		String title = doc.title();
		System.out.println(title);
		
		String html = "<html><head><title>First parse</title?</head?"
				+ "<body><p>Parsed HTML into a doc.</p></body></html>";
		Document d = Jsoup.parse(html);
		System.out.println(d);
	}

	public static void main(String[] args) {
		new Soup();
	}
}
