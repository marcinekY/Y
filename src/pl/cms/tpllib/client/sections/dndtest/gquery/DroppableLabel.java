package pl.cms.tpllib.client.sections.dndtest.gquery;

import gwtquery.plugins.droppable.client.DroppableOptions.DroppableTolerance;
import gwtquery.plugins.droppable.client.gwt.DroppableWidget;

import com.google.gwt.user.client.ui.Label;

public class DroppableLabel extends DroppableWidget<Label> {

	public DroppableLabel() {
		Label label = new Label("I want to be a droppable widget !!");
	    //wrap the original widget in a DroppableWidget
	    DroppableWidget<Label> droppableLabel = new DroppableWidget<Label>(label);
	    //configure the drop behaviour (see next paragraph)
	    droppableLabel.setTolerance(DroppableTolerance.POINTER);
	    
	    //add the droppableLabel to the DOM
	    RootPanel.get().add(droppableLabel);
	    
	    //if you want to do something in the original label, just call getOriginalWidget method
	    droppableLabel.getOriginalWidget().setText("I'm now droppable");

	}


}
