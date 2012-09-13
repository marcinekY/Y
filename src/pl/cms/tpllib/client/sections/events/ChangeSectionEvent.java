package pl.cms.tpllib.client.sections.events;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;

import com.google.gwt.event.shared.GwtEvent;

public class ChangeSectionEvent extends GwtEvent<ChangeSectionEventHandler> {
	
	public static Type<ChangeSectionEventHandler> TYPE = new Type<ChangeSectionEventHandler>();
	private SectionDataEntry sectionData;

	public ChangeSectionEvent(SectionDataEntry sectionEntry) {
		this.sectionData = sectionEntry;
	}
	
	
	public SectionDataEntry getSectionData(){
		return sectionData;
	}

	@Override
	public Type<ChangeSectionEventHandler> getAssociatedType() {
		return TYPE;
	}

	@Override
	protected void dispatch(ChangeSectionEventHandler handler) {
		handler.onSectionChanged(this);
	}
}
