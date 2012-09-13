package pl.cms.system.client.uisystem;

import com.google.gwt.user.client.ui.PopupPanel;

public class SectionMngPopup extends PopupPanel {

	public SectionMngPopup() {
		super(true);
		add(new SectionMngPanel());
	}

}
