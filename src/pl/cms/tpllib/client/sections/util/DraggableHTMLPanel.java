package pl.cms.tpllib.client.sections.util;

import gwtquery.plugins.draggable.client.DraggableOptions.AxisOption;
import gwtquery.plugins.draggable.client.DraggableOptions.RevertOption;
import gwtquery.plugins.draggable.client.events.DragStartEvent;
import gwtquery.plugins.draggable.client.events.DragStartEvent.DragStartEventHandler;
import gwtquery.plugins.draggable.client.events.DragStopEvent;
import gwtquery.plugins.draggable.client.events.DragStopEvent.DragStopEventHandler;
import gwtquery.plugins.draggable.client.gwt.DraggableWidget;

import com.google.gwt.dom.client.Style.Cursor;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.Label;

public class DraggableHTMLPanel {

	private HTMLPanel panel = new HTMLPanel("Draggable HTMLPanel");
	private DraggableWidget<HTMLPanel> draggablePanel = new DraggableWidget<HTMLPanel>(panel);

	public DraggableHTMLPanel() {
		panel.setPixelSize(100, 100);
		panel.addStyleName("testdraghtml");
		
		
		draggablePanel.addDragStartHandler(new DragStartEventHandler() {

			public void onDragStart(DragStartEvent event) {
				// retrieve the widget that is being dragged
//				DraggableWidget<HTMLPanel> draggableWidget = (DraggableWidget<HTMLPanel>) event
//						.getDraggableWidget();
				setInnerHTML("I'm dragging");
			}
		});

		// as DraggableWidget is a composite call initWidget() method to setup
		// your widget
		draggablePanel.addDragStopHandler(new DragStopEventHandler() {

			public void onDragStop(DragStopEvent event) {
				setInnerHTML("Draggable HTMLPanel");
				// retrieve the widget that was being dragged
//				DraggableWidget<HTMLPanel> draggableWidget = (DraggableWidget<HTMLPanel>) event
//						.getDraggableWidget();
//				draggableWidget.getOriginalWidget().getElement().setInnerHTML("I'm not dragging");

			}
		});

		//configure the drag behavior
	    //use a clone of the helper as dragging display
	    draggablePanel.useOriginalWidgetAsHelper();
	    //change the cursor during the drag
	    draggablePanel.setDraggingCursor(Cursor.MOVE);
	    //set the opacity of the dragging display
	    draggablePanel.setDraggingOpacity((float)0.8);
	    // the widget can only be dragged on horizontal axis
//	    draggablePanel.setAxis(AxisOption.Y_AXIS);
	    //revert the dragging display on its original position is not drop occured
	    draggablePanel.setRevert(RevertOption.ON_INVALID_DROP);
	    //snap the dragging display to a 50x50px grid
//	    draggablePanel.setGrid(new int[]{50,50});


	}
	
	public void setInnerHTML(String html){
		draggablePanel.getOriginalWidget().getElement().setInnerHTML(html);
	}

	public HTMLPanel getPanel() {
		return panel;
	}

	public void setPanel(HTMLPanel panel) {
		this.panel = panel;
	}

	public DraggableWidget<HTMLPanel> getDraggablePanel() {
		return draggablePanel;
	}

	public void setDraggablePanel(DraggableWidget<HTMLPanel> draggablePanel) {
		this.draggablePanel = draggablePanel;
	}
	
	
	
	

}
