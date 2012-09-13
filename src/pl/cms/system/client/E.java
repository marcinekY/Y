package pl.cms.system.client;

import java.util.logging.Level;
import java.util.logging.Logger;

import pl.cms.system.client.mvp.AppActivityMapper;
import pl.cms.system.client.mvp.AppPlaceHistoryMapper;
import pl.cms.system.client.place.SamplePlace;
import pl.cms.system.client.uihelpers.OneWidgetHTMLPanel;

import com.google.gwt.activity.shared.ActivityManager;
import com.google.gwt.activity.shared.ActivityMapper;
import com.google.gwt.core.client.EntryPoint;
import com.google.gwt.core.client.GWT;
import com.google.gwt.core.client.Scheduler;
import com.google.gwt.event.shared.EventBus;
import com.google.gwt.place.shared.Place;
import com.google.gwt.place.shared.PlaceController;
import com.google.gwt.place.shared.PlaceHistoryHandler;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.user.client.ui.AbsolutePanel;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.RootLayoutPanel;

public class E implements EntryPoint {
	
	private Logger LOG = Logger.getLogger("SAMPLE");
  

//	private Place defaultPlace = new LayoutDesignerPlace("testToolbar");
	private Place defaultPlace = new SamplePlace("sample");
	
	interface Binder extends UiBinder<AbsolutePanel, E> {
	}
	
	private static final Binder binder = GWT.create(Binder.class);
	
	@UiField AbsolutePanel panel;
	@UiField OneWidgetHTMLPanel contentPanel;
	@UiField HTMLPanel menuBarPanel;
//	@UiField ScrollPanel outer;
	
	public void onModuleLoad() {
		
		GWT.setUncaughtExceptionHandler(new GWT.UncaughtExceptionHandler() {

			public void onUncaughtException(Throwable caught) {
				LOG.log(Level.SEVERE, "uncaught exception", caught);
			}
		});

		Scheduler.get().scheduleDeferred(new Scheduler.ScheduledCommand() {

			public void execute() {
				init();
			}
		});

	}

//	protected void inittest(){
//		RootLayoutPanel.get().add(new DraggableLabel());
//	}
	
	protected void init() {
		panel = binder.createAndBindUi(this);
//		panel.setSize("100%", "400px");
		// Create ClientFactory using deferred binding so we can replace with 
		// different impls in gwt.xml
		ClientFactory clientFactory = GWT.create(ClientFactory.class);
		EventBus eventBus = clientFactory.getEventBus();
		PlaceController placeController = clientFactory.getPlaceController();
		// Start ActivityManager for the main widget with our ActivityMapper
		ActivityMapper activityMapper = new AppActivityMapper(clientFactory);
		ActivityManager activityManager = new ActivityManager(activityMapper, eventBus);
		activityManager.setDisplay(contentPanel);
		// Start PlaceHistoryHandler with our PlaceHistoryMapper
		AppPlaceHistoryMapper historyMapper = GWT .create(AppPlaceHistoryMapper.class);
		PlaceHistoryHandler historyHandler = new PlaceHistoryHandler(historyMapper);
		historyHandler.register(placeController, eventBus, defaultPlace);
		
//		menuBarPanel.add(l);
//		menuBarPanel.add(new SectionMngPanel());
		
//		CssBase base = new CssBase();
		
//		HTMLPanel p = new HTMLPanel("htmlPanel");
//		p.addStyleName("testBox");
//		contentPanel.add(p);
//		
//		
//		String s = ".testBox { width:100px; height:10px; border: 2px solid #000000; background-color: yellow; } .gwt-DialogBox .Caption { background-image: url(gray_gradient.gif); background-repeat: repeat-x;	padding: 4px; padding-bottom: 8px; font-weight: bold; cursor: default; }";
//		
//		Element style = DOM.createElement("style");
//		style.setAttribute("type", "text/css");
//		style.setInnerText(s);
//		
//		menuBarPanel.getElement().appendChild(style);
//		
//		
//		NodeList<Node> nodes = style.getChildNodes();
//		for (int i = 0; i < nodes.getLength(); i++) {
////			Window.alert(String.valueOf());
//		}
		
		
		panel.setWidgetPosition(menuBarPanel, 0, 0);
		panel.setWidgetPosition(contentPanel, 0, 20);
		
		RootLayoutPanel.get().add(panel);
		// Goes to place represented on URL or default place
		historyHandler.handleCurrentHistory();
	}
}



