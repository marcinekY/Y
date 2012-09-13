package pl.cms.tpllib.client.sections.events;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;

import com.google.gwt.event.shared.GwtEvent;

public class AddSectionEvent extends GwtEvent<AddSectionEventHandler> {
	
	public static Type<AddSectionEventHandler> TYPE = new Type<AddSectionEventHandler>();
	private SectionDataEntry sectionData;

	public AddSectionEvent(SectionDataEntry sectionEntry) {
		this.sectionData = sectionEntry;
	}
	
	
	public SectionDataEntry getSectionData(){
		return sectionData;
	}

	@Override
	public Type<AddSectionEventHandler> getAssociatedType() {
		return TYPE;
	}

	@Override
	protected void dispatch(AddSectionEventHandler handler) {
		handler.onSectionAdd(this);
	}
}
