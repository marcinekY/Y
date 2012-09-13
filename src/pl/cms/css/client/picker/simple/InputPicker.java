package pl.cms.css.client.picker.simple;

import pl.cms.helpers.client.var.Value;

import com.google.gwt.event.dom.client.ChangeEvent;
import com.google.gwt.event.dom.client.ChangeHandler;
import com.google.gwt.user.client.ui.TextBox;

public class InputPicker extends SimplePickerImpl {

	TextBox input = new TextBox();
	
	public InputPicker() {
		this.value = new Value();
		init();
	}
	
	public InputPicker(Value value) {
		this.value = value;
		init();
	}
	
	private void init(){
		initWidget(input);
		
		input.addDomHandler(new ChangeHandler() {
			@Override
			public void onChange(ChangeEvent event) {
				Value v = new Value(value.getName(), input.getValue());
				setValue(v);
			}
		}, ChangeEvent.getType());
		
	}
	
}
