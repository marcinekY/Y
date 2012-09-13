package pl.cms.css.client.picker.simple;

import pl.cms.helpers.client.var.Value;


import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.dom.client.ClickHandler;
import com.google.gwt.user.client.Event;
import com.google.gwt.user.client.ui.Button;

public class ButtonPicker extends SimplePickerImpl {

	Button picker = new Button();
	
	public ButtonPicker(Value value){
		this.value = value;
		picker.setText(value.getValue().toString());
		init();
	}
	
	private void init(){
		initWidget(picker);
		picker.sinkEvents(Event.ONCLICK);
		picker.addHandler(new ClickHandler() {
			@Override
			public void onClick(ClickEvent event) {
				
				listener.setValue(value);
			}
		},ClickEvent.getType());
	}
}
