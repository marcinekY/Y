package pl.cms.tpllib.client.sections.events;

import com.google.gwt.event.shared.EventHandler;

public interface SelectSectionEventHandler extends EventHandler {
	void onSectionSelect(SelectSectionEvent sectionSelectEvent);
}
