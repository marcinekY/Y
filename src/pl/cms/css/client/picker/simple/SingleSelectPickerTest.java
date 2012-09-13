package pl.cms.css.client.picker.simple;

import java.util.ArrayList;

import pl.cms.helpers.client.var.Value;

import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.HorizontalPanel;
import com.google.gwt.user.client.ui.Label;

public class SingleSelectPickerTest extends Composite implements SimplePicker {

	private SelectPickerPopup select;
	
	private ArrayList<Value> values = new ArrayList<Value>();
	
	private HorizontalPanel panel = new HorizontalPanel();
	Label l = new Label();
	
	public SingleSelectPickerTest() {
		select = new SelectPickerPopup();
		values.add(new Value("position", null));
		
		Value v1 = new Value("position", "absolute");
		select.addItem(v1, "absolutna");
		Value v2 = new Value("position", "relative");
		select.addItem(v2, "relatywna");
		Value v3 = new Value("position", "static");
		select.addItem(v3, "statyczna");

		
		select.setListener(this);
		panel.add(new Label("Pozycja:"));
		panel.add(select);
		
		panel.add(l);
		initWidget(panel);
		
	}

	@Override
	public void setValue(Value value) {
		values.get(0).setValue(value);
		l.setText(value.getName()+":"+value.getValue());
	}

}
