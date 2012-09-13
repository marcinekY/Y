package pl.cms.tpllib.client.sections.events;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;

import com.google.gwt.event.shared.GwtEvent;

public class SelectSectionEvent extends GwtEvent<SelectSectionEventHandler> {
	
	public static Type<SelectSectionEventHandler> TYPE = new Type<SelectSectionEventHandler>();
	private String id;

	public SelectSectionEvent(String id) {
		this.id = id;
	}
	
	
	public String getId(){
		return id;
	}

	@Override
	public Type<SelectSectionEventHandler> getAssociatedType() {
		return TYPE;
	}

	@Override
	protected void dispatch(SelectSectionEventHandler handler) {
		handler.onSectionSelect(this);
	}
}
