package pl.cms.system.client.ui;

import pl.cms.css.client.picker.simple.SingleColorPickerTest;
import pl.cms.css.client.picker.simple.SingleInputPickerTest;
import pl.cms.css.client.picker.simple.SingleSelectPickerTest;
import pl.cms.system.client.uisystem.SectionMngPopup;

import com.google.gwt.core.client.GWT;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.place.shared.Place;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.uibinder.client.UiHandler;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.FlowPanel;
import com.google.gwt.user.client.ui.Widget;

/**
 * Sample implementation of {@link SampleView}.
 */
public class SampleViewImpl extends Composite implements SampleView {

	interface Binder extends UiBinder<Widget, SampleViewImpl> {
	}
	
	private static final Binder binder = GWT.create(Binder.class);

	private Presenter listener;
	
	@UiField FlowPanel panel;
	@UiField
	Button button;

	public SampleViewImpl() {
		initWidget(binder.createAndBindUi(this));
		panel.add(new SingleColorPickerTest());
		SingleInputPickerTest sp = new SingleInputPickerTest();
		panel.add(sp);
		panel.add(new SingleSelectPickerTest());
		
		
		
	}

	@Override
	public void setName(String name) {
		button.setHTML(name);
	}

	@Override
	public void setPresenter(Presenter listener) {
		this.listener = listener;
	}

	@UiHandler("button")
	void onButtonClick(ClickEvent event) {
		Place newPlace = null;
		panel.add(new SectionMngPopup());
		listener.goTo(newPlace);
	}


}
