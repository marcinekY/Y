package pl.cms.system.client;

import pl.cms.helpers.client.json.DataHolder;
import pl.cms.helpers.client.json.DataHolderImpl;
import pl.cms.system.client.ui.GeneralSettingsView;
import pl.cms.system.client.ui.GeneralSettingsViewImpl;
import pl.cms.system.client.ui.LayoutDesignerView;
import pl.cms.system.client.ui.LayoutDesignerViewImpl;
import pl.cms.system.client.ui.SampleView;
import pl.cms.system.client.ui.SampleViewImpl;

import com.google.gwt.event.shared.EventBus;
import com.google.gwt.event.shared.SimpleEventBus;
import com.google.gwt.place.shared.PlaceController;

/**
 * Sample implementation of {@link ClientFactory}.
 */
public class ClientFactoryImpl implements ClientFactory {
  
	private static final EventBus eventBus = new SimpleEventBus();
	private static final PlaceController placeController = new PlaceController(eventBus);
	private static final DataHolder dataHolder = new DataHolderImpl(eventBus);
	private static final SampleView view = new SampleViewImpl();

	private static final LayoutDesignerView layoutDesignerView = new LayoutDesignerViewImpl();
	private static final GeneralSettingsView generalSettingsView = new GeneralSettingsViewImpl();
	
	
	@Override
	public EventBus getEventBus() {
		return eventBus;
	}

	@Override
	public PlaceController getPlaceController() {
		return placeController;
	}
	
	@Override
	public DataHolder getDataHolder() {
		return dataHolder;
	}

	@Override
	public SampleView getSampleView() {
		return view;
	}

	@Override
	public LayoutDesignerView getLayoutDesigner() {
		return layoutDesignerView;
	}

	@Override
	public GeneralSettingsView getGeneralaSettings() {
		return generalSettingsView;
	}


}
