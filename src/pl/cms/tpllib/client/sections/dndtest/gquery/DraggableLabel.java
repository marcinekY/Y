package pl.cms.tpllib.client.sections.dndtest.gquery;

import gwtquery.plugins.draggable.client.DraggableOptions.AxisOption;
import gwtquery.plugins.draggable.client.DraggableOptions.RevertOption;
import gwtquery.plugins.draggable.client.events.DragStartEvent;
import gwtquery.plugins.draggable.client.events.DragStartEvent.DragStartEventHandler;
import gwtquery.plugins.draggable.client.events.DragStopEvent;
import gwtquery.plugins.draggable.client.events.DragStopEvent.DragStopEventHandler;
import gwtquery.plugins.draggable.client.gwt.DraggableWidget;

import com.google.gwt.dom.client.Style.Cursor;
import com.google.gwt.user.client.ui.Label;

public class DraggableLabel {

	Label label = new Label("I want to be a droppable widget !!");
	DraggableWidget<Label> draggableLabel = new DraggableWidget<Label>(label);

	public DraggableLabel() {
		
		draggableLabel.addDragStartHandler(new DragStartEventHandler() {

			public void onDragStart(DragStartEvent event) {
				// retrieve the widget that is being dragged
				DraggableWidget<Label> draggableWidget = (DraggableWidget<Label>) event
						.getDraggableWidget();
				draggableWidget.getOriginalWidget().setText("I'm dragging");
			}
		});

		// as DraggableWidget is a composite call initWidget() method to setup
		// your widget
		draggableLabel.addDragStopHandler(new DragStopEventHandler() {

			public void onDragStop(DragStopEvent event) {
				// retrieve the widget that was being dragged
				DraggableWidget<Label> draggableWidget = (DraggableWidget<Label>) event
						.getDraggableWidget();
				draggableWidget.getOriginalWidget().setText("I'm not dragging");

			}
		});

		//configure the drag behavior
	    //use a clone of the helper as dragging display
	    draggableLabel.useOriginalWidgetAsHelper();
	    //change the cursor during the drag
	    draggableLabel.setDraggingCursor(Cursor.MOVE);
	    //set the opacity of the dragging display
	    draggableLabel.setDraggingOpacity((float)0.8);
	    // the widget can only be dragged on horizontal axis
	    draggableLabel.setAxis(AxisOption.Y_AXIS);
	    //revert the dragging display on its original position is not drop occured
	    draggableLabel.setRevert(RevertOption.ON_INVALID_DROP);
	    //snap the dragging display to a 50x50px grid
	    draggableLabel.setGrid(new int[]{50,50});


	}

}
