package pl.cms.tpllib.client.sections;

import gwtquery.plugins.droppable.client.events.DropEvent;
import gwtquery.plugins.droppable.client.events.DropEvent.DropEventHandler;
import gwtquery.plugins.droppable.client.gwt.DroppableWidget;

import java.util.ArrayList;

import pl.cms.tpllib.client.css.entry.MyCss;
import pl.cms.tpllib.client.sections.util.SectionPanel;

import com.google.gwt.event.shared.EventBus;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.Label;
import com.google.gwt.user.client.ui.Widget;

public class SectionsView2 extends Composite {
	
	

//	private ArrayList<SectionPanel> sections;
	
	private Label sectionLabel = new Label("Add your section here...");
	DroppableWidget<Label> droppableSectionWidget = new DroppableWidget<Label>(sectionLabel);

	
	
	private SectionPanel rootPanel;
	
	private ArrayList<SectionPanel> panels = new ArrayList<SectionPanel>();
	
//	PickupDragController dragController;

	private EventBus eventBus;
	

	
	public SectionsView2() {
		sectionLabel.setStyleName("Y-system-SectionsPanelView");
		
//		MyCss c = new MyCss();
		
		droppableSectionWidget.setDroppableHoverClass("Y-system-SectionsPanelView-selected");
		droppableSectionWidget.setGreedy(true);
	    // add a drop handler
		droppableSectionWidget.addDropHandler(new DropEventHandler() {

	      int counter = 0;

	      public void onDrop(DropEvent event) {
	        Widget droppedImage = event.getDraggableWidget();
	        droppedImage.removeFromParent();
	        counter++;
	        sectionLabel.setText("I ate " + counter + " image"
	            + (counter > 1 ? "s" : ""));

	      }
	    });
		
		initWidget(droppableSectionWidget);

		
//		panel.setSize("100%", String.valueOf(Window.getClientHeight()+"px"));
		
//		dragController = new PickupDragController(panel, true);
		
		
		
	}
	
	

	public void setEventBus(EventBus eventBus) {
		this.eventBus = eventBus;

	}

	

}
