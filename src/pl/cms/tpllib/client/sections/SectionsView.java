package pl.cms.tpllib.client.sections;

import java.util.ArrayList;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;
import pl.cms.tpllib.client.sections.events.AddSectionEvent;
import pl.cms.tpllib.client.sections.events.AddSectionEventHandler;
import pl.cms.tpllib.client.sections.events.ChangeSectionEvent;
import pl.cms.tpllib.client.sections.events.ChangeSectionEventHandler;
import pl.cms.tpllib.client.sections.util.SectionPanel;

import com.allen_sauer.gwt.dnd.client.PickupDragController;
import com.google.gwt.core.client.GWT;
import com.google.gwt.event.shared.EventBus;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.user.client.Window;
import com.google.gwt.user.client.ui.AbsolutePanel;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.Widget;

public class SectionsView extends Composite {

	private static SectionsMngPanelUiBinder uiBinder = GWT
			.create(SectionsMngPanelUiBinder.class);

	interface SectionsMngPanelUiBinder extends
			UiBinder<Widget, SectionsView> {
	}

//	private ArrayList<SectionPanel> sections;
	
	@UiField AbsolutePanel panel;
	
	
	
	private SectionPanel rootPanel;
	
	private ArrayList<SectionPanel> panels = new ArrayList<SectionPanel>();
	
	PickupDragController dragController;

	private EventBus eventBus;
	
	public SectionsView() {
		initWidget(uiBinder.createAndBindUi(this));
		panel.setSize("100%", String.valueOf(Window.getClientHeight()+"px"));
		
		dragController = new PickupDragController(panel, true);
		
		
		
	}
	
	private void addHandlers() {
//		eventBus.addHandler(AddSectionEvent.TYPE, new AddSectionEventHandler() {
//			
//			@Override
//			public void onSectionAdd(AddSectionEvent sectionAddEvent) {
//				addSection(sectionAddEvent.getSectionData());
//			}
//		});
	}
	
//	public int getSectionIndex(SectionPanel section){
//		int index = sections.indexOf(section);
//		return index;
//	}
	
//	public SectionPanel getSection(String id){
//	if(getSections()!=null){
//		for(int i=0;i<getSections().size();i++){
//			if(getSections().get(i).getId().equals(id)){
//				return getSections().get(i);
//			}
//			if(getSections().get(i).getSection(id)!=null) {
//				return getSections().get(i).getSection(id);
//			}
//		}
//	}
//	return null;
//}
	
//	public SectionPanel getSelectSection(){
//		if(panels!=null){
//			for (int i = 0; i < panels.size(); i++) {
//				if(panels)
//			}
//		}
//		return null;
//	}
//	
	public void refreshPanel(String id){
		getSectionPanel(id).refreshContent();
	}
	
	public void addSection(SectionDataEntry se){
		SectionPanel sp = new SectionPanel(se);
		
		SectionPanel root = getSectionPanel(se.getParentId());
		if(rootPanel==null || root==null){
			rootPanel = sp;
			panel.add(rootPanel.asWidget());
		} else {
			root.addSection(sp);
		}
		sp.setDragController(dragController);
		panels.add(sp);
	}
	
	public SectionPanel getSectionPanel(String id){
		if(panels.size()>0){
			for (int i = 0; i < panels.size(); i++) {
				if(panels.get(i).getData().getId().equals(id)){
					return panels.get(i);
				}
			}
		}
		return null;
	}
	
	/**
	 * @param section
	 */
//	public void addSection(String parentId, SectionPanel section){
//		if(getId().equals(parentId)) addSection(section);
//		else getSection(parentId).addSection(section);
////		if(section.getId()==null){
////			sections.add(section);
////			panel.add(section.getContent());
////		}
////		section.setId(String.valueOf(sections.indexOf(section)));
////		if(section.getParentId()>-1){
////			sections.get(section.getParentId()).addSection(section);
////			
////		} 
//		
//		
//		
////		if(panel.getWidgetCount()==0) sections.get(0).addSection(section)
//		
//		
////		if(section.getId()!=null){
////			String id = section.getId();
////			sections.get(Integer.valueOf(id)).removeFromParent();
////			sections.remove(Integer.valueOf(id));
////		}
////		sections.add(section);
////		int index = sections.indexOf(section);
////		section.setId(String.valueOf(index));
////		Direction dir = section.getDirection();
////		switch (dir) {
////			case NORTH:
////				panel.addNorth(section.getContent(), 150);
////				break;
////			case EAST:
////				panel.addEast(section.getContent(), 150);
////				break;
////			case SOUTH:
////				panel.addSouth(section.getContent(), 150);
////				break;
////			case WEST:
////				panel.addWest(section.getContent(), 150);
////				break;
////			case CENTER:
////				
////				panel.add(section.getContent());
////				break;
////			default:
////				break;
////		}
//		
//		
//	}

//	public ArrayList<SectionPanel> getSections() {
//		return sections;
//	}
//
//	public void setSections(ArrayList<SectionPanel> sections) {
//		this.sections = sections;
//	}

//	public SectionsArr getSections() {
//		return sections;
//	}
//
//	public void setSections(SectionsArr sections) {
//		this.sections = sections;
//	}
	
	public AbsolutePanel getPanel() {
		return panel;
	}

	public void setPanel(AbsolutePanel panel) {
		this.panel = panel;
	}

	public PickupDragController getDragController() {
		return dragController;
	}

	public void setDragController(PickupDragController dragController) {
		this.dragController = dragController;
	}

	public void setEventBus(EventBus eventBus) {
		this.eventBus = eventBus;
		addHandlers();
	}

	

}
