package pl.cms.system.client.activity;

import pl.cms.helpers.client.json.AddDataEvent;
import pl.cms.helpers.client.json.AddDataEventHandler;
import pl.cms.helpers.client.json.DataEntry;
import pl.cms.helpers.client.json.DataHolder;
import pl.cms.system.client.ClientFactory;
import pl.cms.system.client.model.presenter.Presenter;
import pl.cms.system.client.place.LayoutDesignerPlace;
import pl.cms.system.client.ui.LayoutDesignerView;
import pl.cms.css.client.CssDataBase;

import com.google.gwt.activity.shared.AbstractActivity;
import com.google.gwt.event.shared.EventBus;
import com.google.gwt.place.shared.Place;
import com.google.gwt.user.client.ui.AcceptsOneWidget;

/**
 * Activities are started and stopped by an ActivityManager associated with a container Widget.
 */
public class LayoutDesignerActivity extends AbstractActivity implements LayoutDesignerView.Presenter, DataHolder.ActivitySetter {
	/**
	 * Used to obtain views, eventBus, placeController.
	 * Alternatively, could be injected via GIN.
	 */
	private ClientFactory clientFactory;

	/**
	 * Sample property.
	 */
	private String name;
	
	LayoutDesignerView view;

	public LayoutDesignerActivity(LayoutDesignerPlace place, ClientFactory clientFactory) {
		this.name = place.getName();
		this.clientFactory = clientFactory;
	}

	@Override
	public void start(AcceptsOneWidget containerWidget, EventBus eventBus) {
		view = clientFactory.getLayoutDesigner();
		view.setEventBus(clientFactory.getEventBus());
		view.setName(name);
		view.setPresenter(this);
		
		view.startView();
		containerWidget.setWidget(view.asWidget());
	}

	@Override
	public String mayStop() {
		return "Please hold on. This activity is stopping.";
	}

	/**
	 * @see LayoutDesignerView.Presenter#goTo(Place)
	 */
	public void goTo(Place place) {
		clientFactory.getPlaceController().goTo(place);
	}
	
	/**
	 * pobiera dane z repozytorium
	 * @see LayoutDesignerView.Presenter#getData(String)
	 */
	@Override
	public void getData(final String name) {
		clientFactory.getDataHolder().getData(name,this);
	}

	@Override
	public void setData(DataEntry data) {
		if(data.getName().equals("cssdata")){
			
		}
		// TODO Auto-generated method stub
		return;
	}
	
}
