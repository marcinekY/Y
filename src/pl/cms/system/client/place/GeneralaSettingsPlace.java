package pl.cms.system.client.place;

import com.google.gwt.place.shared.Place;
import com.google.gwt.place.shared.PlaceTokenizer;

/**
 * A place object representing a particular state of the UI. A Place can be converted to and from a
 * URL history token by defining a {@link PlaceTokenizer} for each {@link Place}, and the 
 * {@link PlaceHistoryHandler} automatically updates the browser URL corresponding to each 
 * {@link Place} in your app.
 */
public class GeneralaSettingsPlace extends Place {
  
	/**
	 * Sample property (stores token). 
	 */
	private String name;

	public GeneralaSettingsPlace(String token) {
		this.name = token;
	}

	public String getName() {
		return name;
	}

	/**
	 * PlaceTokenizer knows how to serialize the Place's state to a URL token.
	 */
	public static class Tokenizer implements PlaceTokenizer<GeneralaSettingsPlace> {

		@Override
		public String getToken(GeneralaSettingsPlace place) {
			return place.getName();
		}

		@Override
		public GeneralaSettingsPlace getPlace(String token) {
			return new GeneralaSettingsPlace(token);
		}

	}
}
