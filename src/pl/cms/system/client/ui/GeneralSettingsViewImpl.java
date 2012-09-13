package pl.cms.system.client.ui;

import java.util.ArrayList;

import com.google.gwt.core.client.GWT;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.place.shared.Place;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.uibinder.client.UiHandler;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.HTMLPanel;
import com.google.gwt.user.client.ui.Widget;

/**
 * Sample implementation of {@link GeneralSettingsView}.
 */
public class GeneralSettingsViewImpl extends Composite implements GeneralSettingsView {

	interface Binder extends UiBinder<Widget, GeneralSettingsViewImpl> {
	}
	
	private static final Binder binder = GWT.create(Binder.class);
	
	private ArrayList<String> settings = new ArrayList<String>();

	private Presenter listener;
	@UiField
	HTMLPanel panel;

	public GeneralSettingsViewImpl() {
		initWidget(binder.createAndBindUi(this));
	}


	@Override
	public void setPresenter(Presenter listener) {
		this.listener = listener;
	}


}
