package pl.cms.css.client.picker.simple.color.test;

import com.google.gwt.canvas.client.Canvas;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.Label;
import com.google.gwt.user.client.ui.TextBox;
import com.google.gwt.user.client.ui.ToggleButton;

public class ColorPicker extends Composite {
	private ToggleButton handler;
	private Canvas canvas = Canvas.createIfSupported();
	private HTMLPanel panel;

	public ColorPicker() {
		panel = new HTMLPanel("");
		panel.setPixelSize(400, 400);
		panel.getElement().setPropertyString("background-color", "#cccccc");
		
		
		panel.add(new SaturationLightnessPicker());
		
		panel.add(new HuePicker());
		
//		canvas.getContext2d().setFillStyle("#ff0000");
//		canvas.getContext2d().fillRect(10, 10, 20, 20);
		
		
		
		handler = new ToggleButton("H");
		panel.add(handler);
		initWidget(panel);
	}

}
