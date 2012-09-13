package pl.cms.tpllib.client.sections.events;

import com.google.gwt.event.shared.EventHandler;

public interface RemoveSectionEventHandler extends EventHandler {
	void onSectionRemove(RemoveSectionEvent sectionRemoveEvent);
}
