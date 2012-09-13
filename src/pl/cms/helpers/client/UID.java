package pl.cms.helpers.client;

public class UID {
	private static int i = 0;

	public static String create(){
		return "y-uid-" + String.valueOf(i++);
	}
}
