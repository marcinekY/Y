package pl.cms.css.client.picker.simple;

import pl.cms.css.client.picker.simple.SimplePickerImpl;
import pl.cms.helpers.client.var.Value;

import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.dom.client.ClickHandler;
import com.google.gwt.event.dom.client.MouseDownEvent;
import com.google.gwt.event.dom.client.MouseDownHandler;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.PopupPanel;
import com.google.gwt.user.client.ui.Widget;

public class PickerPopup<T> extends SimplePickerImpl {

	Button button = new Button("PP");
	private PopupPanel popup = new PopupPanel();
	private T picker;
	
	
	public PickerPopup(T picker) {
		this.picker = picker;
		init();
	}
	
	public PickerPopup(Value value,T picker) {
		this.value = value;
		this.picker = picker;
		init();
	}
	
	private void init(){
		setHandlers();
		setPopupSetings();
		popup.add((Widget)picker);
		initWidget(button);
	}
	
	private void setHandlers(){
//		content.addHandler(new MouseDownHandler() {
//			@Override
//			public void onMouseDown(MouseDownEvent event) {
//				content.onMouseDown(event);
//				value.setValue((content.getSelectedColor()));
//				listener.setValue(value);
//				popup.hide();
//			}
//		}, MouseDownEvent.getType());
		button.addDomHandler(new ClickHandler() {
			@Override
			public void onClick(ClickEvent event) {
				int left = button.getAbsoluteLeft();
				int top = button.getAbsoluteTop();
				popup.setPopupPosition(left, top);
				popup.show();
			}
		},ClickEvent.getType());
	}

	private void setPopupSetings(){
		popup.setAnimationEnabled(false);
		popup.setAutoHideEnabled(true);
	}

	public T getPicker() {
		return picker;
	}

	public void setPicker(T picker) {
		this.picker = picker;
	}

	
}
