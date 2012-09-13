package pl.cms.css.client.picker.simple.temp;

import com.google.gwt.event.dom.client.MouseDownEvent;
import com.google.gwt.event.dom.client.MouseDownHandler;
import com.google.gwt.event.dom.client.MouseMoveEvent;
import com.google.gwt.event.dom.client.MouseMoveHandler;
import com.google.gwt.event.dom.client.MouseUpEvent;
import com.google.gwt.event.dom.client.MouseUpHandler;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.Label;

public class ValuePicker extends Composite implements MouseMoveHandler, MouseDownHandler, MouseUpHandler {

	private int value;
	
	private int startX;
	private Label display = new Label();
	
	public ValuePicker() {
		
		initWidget(display);
	}

	@Override
	public void onMouseUp(MouseUpEvent event) {
		
	}

	@Override
	public void onMouseDown(MouseDownEvent event) {
		event.getX();
	}

	@Override
	public void onMouseMove(MouseMoveEvent event) {
		value = value;
	}

}
