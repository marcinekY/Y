package pl.cms.css.client.picker.simple;

import java.util.ArrayList;

import pl.cms.helpers.client.var.Value;

import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.HorizontalPanel;
import com.google.gwt.user.client.ui.Label;

public class SingleInputPickerTest extends Composite implements SimplePicker {

	private ArrayList<ButtonPicker> pickers = new ArrayList<ButtonPicker>();
	
	private ArrayList<Value> values = new ArrayList<Value>();
	
	private HorizontalPanel panel = new HorizontalPanel();
	Label l = new Label();
	
	public SingleInputPickerTest() {
		values.add(new Value("margin", null));
		Value v1 = new Value("margin", "10px");
		ButtonPicker b1 = new ButtonPicker(v1);
		b1.setListener(this);
		b1.setLayoutData(new Button("5px"));
		panel.add(b1);
		Value v2 = new Value("margin", "20px");
		ButtonPicker b2 = new ButtonPicker(v2);
		b2.setListener(this);
		panel.add(b2);
		InputPicker b3 = new InputPicker();
		b3.setListener(this);
		panel.add(b3);
		panel.add(l);
		initWidget(panel);
		
	}

	@Override
	public void setValue(Value value) {
		values.get(0).setValue(value);
		l.setText(value.getName()+":"+value.getValue());
	}

}
