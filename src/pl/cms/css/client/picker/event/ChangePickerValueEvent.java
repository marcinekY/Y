package pl.cms.css.client.picker.event;



import pl.cms.helpers.client.var.Value;

import com.google.gwt.event.shared.GwtEvent;

public class ChangePickerValueEvent extends GwtEvent<ChangePickerValueEventHandler> {
	
	public static Type<ChangePickerValueEventHandler> TYPE = new Type<ChangePickerValueEventHandler>();
	private Value value;

	public ChangePickerValueEvent(Value value) {
		this.value = value;
	}
	
	public Value getValue(){
		return value;
	}

	@Override
	public Type<ChangePickerValueEventHandler> getAssociatedType() {
		return TYPE;
	}

	@Override
	protected void dispatch(ChangePickerValueEventHandler handler) {
		handler.onPickerValueChange(this);
	}
}
