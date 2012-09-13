package pl.cms.system.client.mvp;

import pl.cms.system.client.ClientFactory;
import pl.cms.system.client.activity.LayoutDesignerActivity;
import pl.cms.system.client.activity.SampleActivity;
import pl.cms.system.client.place.LayoutDesignerPlace;
import pl.cms.system.client.place.SamplePlace;

import com.google.gwt.activity.shared.Activity;
import com.google.gwt.activity.shared.ActivityMapper;
import com.google.gwt.place.shared.Place;

/**
 * ActivityMapper associates each {@link Place} with its corresponding {@link Activity}.
 */
public class AppActivityMapper implements ActivityMapper {

	/**
	 * Provided for {@link Activitie}s.
	 */
	private ClientFactory clientFactory;

	public AppActivityMapper(ClientFactory clientFactory) {
		this.clientFactory = clientFactory;
	}

	@Override
	public Activity getActivity(Place place) {
	  
		if (place instanceof SamplePlace)
			return new SampleActivity((SamplePlace) place, clientFactory);
		else if (place instanceof LayoutDesignerPlace) {
			return new LayoutDesignerActivity((LayoutDesignerPlace) place, clientFactory);
		}

		return null;
	}

}
