package pl.cms.tpllib.client.sections.util;

import java.util.ArrayList;

import pl.cms.tpllib.client.sections.entry.SectionDataEntry;
import sun.java2d.pipe.SpanShapeRenderer.Simple;

import com.allen_sauer.gwt.dnd.client.PickupDragController;
import com.allen_sauer.gwt.dnd.client.drop.DropController;
import com.allen_sauer.gwt.dnd.client.drop.FlowPanelDropController;
import com.allen_sauer.gwt.dnd.client.drop.GridConstrainedDropController;
import com.allen_sauer.gwt.dnd.client.drop.HorizontalPanelDropController;
import com.allen_sauer.gwt.dnd.client.drop.IndexedDropController;
import com.allen_sauer.gwt.dnd.client.drop.SimpleDropController;
import com.allen_sauer.gwt.dnd.client.drop.VerticalPanelDropController;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.FlowPanel;
import com.google.gwt.user.client.ui.Grid;
import com.google.gwt.user.client.ui.HorizontalPanel;
import com.google.gwt.user.client.ui.IndexedPanel;
import com.google.gwt.user.client.ui.Label;
import com.google.gwt.user.client.ui.Panel;
import com.google.gwt.user.client.ui.SimplePanel;
import com.google.gwt.user.client.ui.VerticalPanel;
import com.google.gwt.user.client.ui.Widget;

public class CopyOfSectionPanel extends Composite {


	private Panel content;
	
	SectionDataEntry data;
	ArrayList<CopyOfSectionPanel> sections = new ArrayList<CopyOfSectionPanel>();
	
	PickupDragController dragController;
	private Label sectionName = new Label(); 
	
	/**
	 * @wbp.parser.constructor
	 */
	public CopyOfSectionPanel() {
		init();
	}
	
	public CopyOfSectionPanel(SectionDataEntry data){
		if(data!=null){
			this.data = data;
		}
		init();
	}
	
	private void init(){
		
		
		if(data==null){
			this.data = new SectionDataEntry();
		}
		refreshContent();
//		if(content==null){
//			data.setName("VertcalSectionPanel");
//			VerticalPanel content = new VerticalPanel();
//			content.add(new Label(data.getName()));
//			setContent(content);
//		}
		initWidget(content);
		
	}
	
	public void refreshContent(){
		if(content==null || !getContentType().equals(data.getType())){
			switch (data.getType()) {
			case FLOW:
				content = new FlowPanel();
				break;
			case HORIZONTAL:
				content = new HorizontalPanel();
				break;
			case VERTICAL:
				content = new VerticalPanel();
				break;
			case SIMPLE:
				content = new SimplePanel();
				content.setSize("200px", "100px");
				break;
			default:
				content = new HorizontalPanel();
				break;
			}
		}
		content.setStyleName("Y-system-SectionPanel");
		if(data.isSelect()) content.addStyleName("Y-system-SectionPanel-selected");
		else content.removeStyleName("Y-system-SectionPanel-selected");
		sectionName.removeFromParent();
		refreshContentClass();
		if(sections.size()==0 && data.getType()!=SectionDataEntry.Type.SIMPLE) {
			content.add(getLabel());
		} else {
			for (int i = 0; i < sections.size(); i++) {
				sections.get(i).refreshContent();
			}
		}
	}
	
	
	public SectionDataEntry.Type getContentType(){
		if(content instanceof FlowPanel){
			return SectionDataEntry.Type.FLOW;
		} else if(content instanceof HorizontalPanel){
			return SectionDataEntry.Type.HORIZONTAL;
		} else if(content instanceof VerticalPanel){
			return SectionDataEntry.Type.VERTICAL;
		} else if(content instanceof SimplePanel){
			return SectionDataEntry.Type.SIMPLE;
		}
//		else if(content instanceof Grid){
//			return SectionEntry.Type.GRID;
//		}
		return null;
	}
	
	public Label getLabel(){
		sectionName.setText(data.getType() + " ID:" + data.getId());
		return sectionName;
	}
	
	public void addSection(CopyOfSectionPanel section){
		content.add(section.asWidget());
		section.data.setParentId(data.getId());
		sections.add(section);
		refreshContent();
//		if(section.getOrder()!=-1 && sections.size()>0){
//			ArrayList<SectionPanel> sectionsList = new ArrayList<SectionPanel>();
//			boolean added = false;
//			for(int i=0;i<sections.size();i++){
//				if(sections.get(i).getOrder()>section.getOrder()){
//					added=true;
//					sectionsList.add(section);
//				}
//				sectionsList.add(sections.get(i));
//				if(i==sections.size() && added==false) sectionsList.add(section);
//			}
//			sections = sectionsList;
//		}
	}
	
	public CopyOfSectionPanel getSection(String id){
//		if(this.getData().getId().equals(id)) return this;
		if(sections!=null){
			for(int i=0;i<sections.size();i++){
				if(sections.get(i).getData().getId().equals(id)){
					sections.get(i).getData().setName(sections.get(i).getData().getName()+sections.get(i).getData().getId());
					return sections.get(i);
				}
				if(sections.get(i).getSection(id)!=null) {
					return sections.get(i).getSection(id);
				}
			}
		}
		return null;
	}
	
	public CopyOfSectionPanel getSection(Panel content){
		if(sections!=null){
			for(int i=0;i<sections.size();i++){
				if(sections.get(i).getContent().equals(content)){
					return sections.get(i);
				}
			}
		}
		return null;
	}
	
	
	
//	public void refreshChildrenOrders(){
//	}
	
	

	
	
	
		
	public void setDragController(PickupDragController dragController){
		this.dragController = dragController;
		if(this.dragController!=null){
			
			if (content instanceof FlowPanel){
				DropController dropController = new FlowPanelDropController((FlowPanel) content);
				this.dragController.registerDropController(dropController);
			} else if (content instanceof VerticalPanel) {
				DropController dropController = new VerticalPanelDropController((VerticalPanel) content);
				this.dragController.registerDropController(dropController);
			} else if (content instanceof HorizontalPanel) {
				DropController dropController = new HorizontalPanelDropController((HorizontalPanel) content);
				this.dragController.registerDropController(dropController);
			} else if (content instanceof SimplePanel) {
				DropController dropController = new SimpleDropController((SimplePanel) content);
				this.dragController.registerDropController(dropController);
			} 
			

//			else if (content instanceof Grid) {
//				DropController dropController = new GridConstrainedDropController((Grid) content);
//				this.dragController.registerDropController(dropController);
//			}
		}
	}
	
	public PickupDragController getDragController() {
		return dragController;
	}
	
//	public void addClass(String className) {
//		content.addStyleName(className);
//		classNames.add(className);
//	}
//	
//	public void removeClass(String className) {
//		content.removeStyleName(className);
//		classNames.remove(className);
//	}
//	
	public void refreshContentClass(){
		if(data.getClassNames().size()>0){
			for(int i=0;i<data.getClassNames().size();i++){
				content.addStyleName(data.getClassNames().get(i));
			}
		}
	}
	
	public Panel getContent() {
		return content;
	}

	public void setContent(Panel content) {
		this.content = content;
		refreshContentClass();
	}

	public SectionDataEntry getData() {
		return data;
	}

	public void setData(SectionDataEntry se) {
		this.data = se;
	}
}
