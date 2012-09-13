package pl.cms.system.client;

import pl.cms.helpers.client.json.DataHolder;
import pl.cms.system.client.ui.LayoutDesignerView;
import pl.cms.system.client.ui.SampleView;

import com.google.gwt.event.shared.EventBus;
import com.google.gwt.place.shared.PlaceController;
import pl.cms.system.client.ui.GeneralSettingsView;

/**
 * ClientFactory helpful to use a factory or dependency injection framework like GIN to obtain 
 * references to objects needed throughout your application like the {@link EventBus},
 * {@link PlaceController} and views.
 */
public interface ClientFactory {

	EventBus getEventBus();
	PlaceController getPlaceController();
	DataHolder getDataHolder();
	
	public SampleView getSampleView();
//	public SystemToolbarView getSystemToolbarView();

	public LayoutDesignerView getLayoutDesigner();

	
	public GeneralSettingsView getGeneralaSettings();
}
