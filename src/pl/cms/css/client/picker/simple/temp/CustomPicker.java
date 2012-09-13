package pl.cms.css.client.picker.simple.temp;

import pl.cms.helpers.client.var.Value;

public interface CustomPicker {
	Object getValue();
	public interface IsPickerWidget {
		void setValue(Object value);
	}
}
