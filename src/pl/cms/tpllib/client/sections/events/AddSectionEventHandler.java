package pl.cms.tpllib.client.sections.events;

import com.google.gwt.event.shared.EventHandler;

public interface AddSectionEventHandler extends EventHandler {
	void onSectionAdd(AddSectionEvent sectionAddEvent);
}
