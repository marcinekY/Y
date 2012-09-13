package pl.cms.css.client.picker.event;

import com.google.gwt.event.shared.EventHandler;

public interface ChangePickerValueEventHandler extends EventHandler {
	void onPickerValueChange(ChangePickerValueEvent changePickerValueEvent);
}
