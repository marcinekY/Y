package pl.cms.system.client.ui;

import pl.cms.helpers.client.json.DataEntry;

import com.google.gwt.event.shared.EventBus;
import com.google.gwt.place.shared.Place;
import com.google.gwt.user.client.ui.IsWidget;

/**
 * View base interface.
 * Extends IsWidget so a view impl can easily provide its container widget.
 */
public interface LayoutDesignerView extends IsWidget {
  
	void setName(String helloName);

	void setPresenter(Presenter listener);

	public interface Presenter {
		/**
		 * Navigate to a new Place in the browser.
		 */
		void goTo(Place place);
		
		/**
		 * Get data for this object
		 * @param name
		 */
		void getData(String name);

//		void getData(String name, MyObject o);
	}
	
	void setData(DataEntry data);

	void setEventBus(EventBus eventBus);

	void startView();
}
