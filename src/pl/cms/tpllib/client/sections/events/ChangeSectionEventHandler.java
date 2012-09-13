package pl.cms.tpllib.client.sections.events;

import com.google.gwt.event.shared.EventHandler;

public interface ChangeSectionEventHandler extends EventHandler {
	void onSectionChanged(ChangeSectionEvent sectionChangeEvent);
}
