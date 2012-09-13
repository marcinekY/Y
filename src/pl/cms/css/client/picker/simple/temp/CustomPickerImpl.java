package pl.cms.css.client.picker.simple.temp;

import java.util.ArrayList;

import pl.cms.css.client.picker.event.ChangePickerValueEvent;
import pl.cms.helpers.client.var.Value;

import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.event.dom.client.ClickHandler;
import com.google.gwt.event.shared.EventBus;
import com.google.gwt.user.client.DOM;
import com.google.gwt.user.client.Event;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.PopupPanel;
import com.google.gwt.user.client.ui.Widget;

public class CustomPickerImpl extends Composite implements CustomPicker, CustomPicker.IsPickerWidget {

	private Value value;
	private String text;
	private Widget widget;
	private ArrayList<Widget> popupWidgets;
	private PopupPanel popup = new PopupPanel();
	private IsPickerWidget listener;
	
	private EventBus eventBus;

	
	public CustomPickerImpl(String name){
		value.setName(name);
		widget = new Button("qp");
		init();
	}
	
	public CustomPickerImpl(String name, Widget widget) {
		value.setName(name);
		this.widget = widget;
		initWidget(widget);
		init();
	}
	
	private void init(){
		widget.sinkEvents(Event.ONCLICK);
		widget.addHandler(new ClickHandler() {
			@Override
			public void onClick(ClickEvent event) {
				listener.setValue(event.getSource())
			}
		}, ClickEvent.getType());
	}
	

	
	public void addWidget(Widget w){
		popup.add(w);
	}

	@Override
	public Object getValue() {
		return value.getValue();
	}

	@Override
	public void setValue(Object value) {
		this.value.setValue(value);
		if(eventBus!=null) eventBus.fireEvent(new ChangePickerValueEvent(this.value));
	}

	public String getText() {
		return text;
	}

	public void setText(String text) {
		this.text = text;
	}

	public Widget getWidget() {
		return widget;
	}

	public void setWidget(Widget widget) {
		this.widget = widget;
	}

	public IsPickerWidget getListener() {
		return listener;
	}

	public void setListener(IsPickerWidget listener) {
		this.listener = listener;
	}

	public void setValue(Value value) {
		this.value = value;
	}

}
