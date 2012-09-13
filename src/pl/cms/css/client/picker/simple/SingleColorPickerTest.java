package pl.cms.css.client.picker.simple;

import java.util.ArrayList;

import pl.cms.css.client.picker.simple.color.ColorPickerPalette;
import pl.cms.css.client.picker.simple.color.ColorPickerPopup;
import pl.cms.helpers.client.var.Value;

import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.HorizontalPanel;
import com.google.gwt.user.client.ui.Label;

public class SingleColorPickerTest extends Composite implements SimplePicker {

	private ArrayList<ButtonPicker> pickers = new ArrayList<ButtonPicker>();
	
	private ArrayList<Value> values = new ArrayList<Value>();
	
	private HorizontalPanel panel = new HorizontalPanel();
	Label l = new Label();
	
	public SingleColorPickerTest() {
		values.add(new Value("margin", null));
		Value v1 = new Value("color", "#ffffff");
		ColorPickerPopup b1 = new ColorPickerPopup();
		b1.setListener(this);
		panel.add(b1);
//		Value v2 = new Value("margin", "20px");
//		InputPicker b2 = new InputPicker(v2);
//		b2.setListener(this);
//		panel.add(b2);
		panel.add(l);
		initWidget(panel);
		
	}

	@Override
	public void setValue(Value value) {
		values.get(0).setValue(value);
		l.setText(value.getName()+":"+value.getValue());
	}

}
