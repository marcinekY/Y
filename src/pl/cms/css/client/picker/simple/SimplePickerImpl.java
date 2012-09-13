package pl.cms.css.client.picker.simple;

import pl.cms.helpers.client.var.Value;

import com.google.gwt.event.logical.shared.HasValueChangeHandlers;
import com.google.gwt.event.logical.shared.ValueChangeEvent;
import com.google.gwt.event.logical.shared.ValueChangeHandler;
import com.google.gwt.event.shared.HandlerRegistration;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.Widget;

public class SimplePickerImpl extends Composite implements HasValueChangeHandlers<Value> {

	protected SimplePicker listener;

	protected Value value;

	/**
	 * odpowiednio ostylowany widget (np. button,textbox,...)
	 */
	public Widget widget;

	public SimplePickerImpl() {
		init();
	}

	private void init() {
		if (widget != null) {
			initWidget(widget);
		}
		value = new Value();
		setHandlers();
	}
	
	private void setHandlers(){
		addValueChangeHandler(new ValueChangeHandler<Value>() {
			@Override
			public void onValueChange(ValueChangeEvent<Value> event) {
				if(listener!=null)
					listener.setValue(value);
			}
		});
		
	}
	
	public void setDefault(){
		
	}
	
//	public String getValueName(){
//		return value.getName();
//	}
//	
//	public void setValueName(String valueName){
//		value.setName(valueName);
//	}

	public Value getValue() {
		return value;
	}
	
	protected void setValue(Value v) {
		if(!value.equals(v)) {
			this.value = v;
			ValueChangeEvent.fire(this, value);
		}
	}

//	public void setValue(Object value) {
//		this.value.setValue(value);
//	}

	public void setListener(SimplePicker listener) {
		this.listener = listener;
	}

	public SimplePicker getListener() {
		return listener;
	}

	@Override
	public HandlerRegistration addValueChangeHandler(
			ValueChangeHandler<Value> handler) {
		return addHandler(handler, ValueChangeEvent.getType());
	}


}
