package pl.cms.tpllib.client.sections.events;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;

import com.google.gwt.event.shared.GwtEvent;

public class RemoveSectionEvent extends GwtEvent<RemoveSectionEventHandler> {
	
	public static Type<RemoveSectionEventHandler> TYPE = new Type<RemoveSectionEventHandler>();
	private SectionDataEntry sectionData;

	public RemoveSectionEvent(SectionDataEntry sectionEntry) {
		this.sectionData = sectionEntry;
	}
	
	
	public SectionDataEntry getSectionData(){
		return sectionData;
	}

	@Override
	public Type<RemoveSectionEventHandler> getAssociatedType() {
		return TYPE;
	}

	@Override
	protected void dispatch(RemoveSectionEventHandler handler) {
		handler.onSectionRemove(this);
	}
}
