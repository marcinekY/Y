package pl.cms.css.client.picker.simple.color;

import pl.cms.css.client.picker.simple.SimplePickerImpl;
import pl.cms.helpers.client.var.Value;

import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.dom.client.ClickHandler;
import com.google.gwt.event.dom.client.MouseDownEvent;
import com.google.gwt.event.dom.client.MouseDownHandler;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.PopupPanel;

public class ColorPickerPopup extends SimplePickerImpl {

	Button picker = new Button("C");
	private PopupPanel popup = new PopupPanel();
	private ColorPickerPalette colorPickerPalette;
	
	
	public ColorPickerPopup() {
		value = new Value("color", null);
		init();
	}
	
	public ColorPickerPopup(Value value) {
		this.value = value;
		init();
	}
	
	private void init(){
		colorPickerPalette = new ColorPickerPalette();
		setHandlers();
		
		popup.add(colorPickerPalette);
		setPopupSetings();
		initWidget(picker);
	}
	
	private void setHandlers(){
		colorPickerPalette.addHandler(new MouseDownHandler() {
			@Override
			public void onMouseDown(MouseDownEvent event) {
				colorPickerPalette.onMouseDown(event);
				value.setValue((colorPickerPalette.getSelectedColor()));
				listener.setValue(value);
				popup.hide();
			}
		}, MouseDownEvent.getType());
		picker.addDomHandler(new ClickHandler() {
			@Override
			public void onClick(ClickEvent event) {
				int left = picker.getAbsoluteLeft();
				int top = picker.getAbsoluteTop();
				popup.setPopupPosition(left, top);
				popup.show();
			}
		},ClickEvent.getType());
	}

	private void setPopupSetings(){
		popup.setAnimationEnabled(false);
		popup.setAutoHideEnabled(true);
	}

	
}
