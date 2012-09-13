package pl.cms.system.client.uisystem;

import com.google.gwt.core.client.GWT;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.uibinder.client.UiHandler;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.HasText;
import com.google.gwt.user.client.ui.MenuItem;
import com.google.gwt.user.client.ui.Widget;
import com.google.gwt.user.client.ui.MenuBar;

public class AdminMenu extends Composite {

	private static AdminMenuUiBinder uiBinder = GWT
			.create(AdminMenuUiBinder.class);
	@UiField MenuBar panel;

	interface AdminMenuUiBinder extends UiBinder<Widget, AdminMenu> {
	}

	public AdminMenu() {
		initWidget(uiBinder.createAndBindUi(this));
	}

	public MenuBar getPanel(){
		return panel;
	}
	
	public void addItem(MenuItem item){
		panel.addItem(item);
	}

}
