package pl.cms.tpllib.client.sections.drag;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;
import pl.cms.tpllib.client.sections.entry.SectionDataEntry.Type;
import pl.cms.tpllib.client.sections.util.SectionPanel;

import com.google.gwt.user.client.ui.Image;
import com.google.gwt.user.client.ui.Widget;

public class VerticalSectionHandler {
	private Widget handler;
	private SectionPanel sectionPanel;
	SectionDataEntry se = new SectionDataEntry();
	
	public VerticalSectionHandler(){
		se.setType(Type.VERTICAL);
		sectionPanel = new SectionPanel(se);
		handler = new Image("http://code.google.com/webtoolkit/logo-185x175.png");
		handler.setSize("50px", "50px");
	}
	
	
	
	public void setShowHandler(boolean visible){
		handler.setVisible(visible);
	}
	
	public void setShowSectionPanel(boolean visible){
		sectionPanel.setVisible(visible);
	}

	public Widget getHandler() {
		return handler;
	}

	public void setHandler(Widget handler) {
		this.handler = handler;
	}

	public SectionPanel getSection() {
		return sectionPanel;
	}

	public void setSection(SectionPanel section) {
		this.sectionPanel = section;
	}
}
