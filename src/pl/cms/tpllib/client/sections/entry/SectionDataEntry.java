package pl.cms.tpllib.client.sections.entry;

import java.util.ArrayList;

import pl.cms.helpers.client.UID;

public class SectionDataEntry {
	public enum Type {HORIZONTAL,VERTICAL,FLOW,SIMPLE,GRID};
	
//	private String id = Document.get().createUniqueId();
	private String id = UID.create();
	private String parentId;
	private String behavior;
	private boolean select = false;
	private Type type = Type.SIMPLE;
	private String name = "Current name";
	private ArrayList<SectionDataEntry> sections = new ArrayList<SectionDataEntry>();
	private ArrayList<String> classNames = new ArrayList<String>();
	
	
	
	
	public SectionDataEntry(){
	}
	
	public SectionDataEntry getSection(String id){
		if(getId().equals(id)) return this;
		if(sections!=null){
			for(int i=0;i<sections.size();i++){
				if(sections.get(i).getId().equals(id)){
					return sections.get(i);
				}
			}
		}
		return null;
	}
	
	public SectionDataEntry getSelectSection(){
		if(isSelect()) return this;
		if(sections!=null){
			for(int i=0;i<sections.size();i++){
				if(sections.get(i).isSelect()){
					return sections.get(i);
				}
			}
		}
		return null;
	}
	
	public void setType(String value) {
		if(value.contains(String.valueOf(Type.FLOW))){
			type = Type.FLOW;
		} else if(value.contains(String.valueOf(Type.HORIZONTAL))) {
			type = Type.HORIZONTAL;
		} else if(value.contains(String.valueOf(Type.VERTICAL))) {
			type = Type.VERTICAL;
		} else if(value.contains(String.valueOf(Type.SIMPLE))) {
			type = Type.SIMPLE;
		}
//		else if(value.contains(String.valueOf(Type.GRID))) {
//			type = Type.GRID;
//		}
	}
	
	public void addSection(SectionDataEntry section){
		if(sections!=null){
			if(section.getParentId()==null) section.setParentId(getId());
			sections.add(section);
		}
	}
	
	public void addSection(int index, SectionDataEntry section){
		if(sections!=null){
			sections.add(index,section);
		}
	}
	
	public int getSectionIndex(SectionDataEntry section){
		return sections.indexOf(section);
	}
	
	public void moveSection(int index,SectionDataEntry section){
		SectionDataEntry s = cutSection(section);
		if(s!=null){
			sections.add(index, s);
		}
	}
	
	public boolean removeSection(SectionDataEntry section){
		if(sections!=null){
			return sections.remove(sections);
		}
		return false;
	}
	
	public SectionDataEntry cutSection(SectionDataEntry section){
		int index = getSectionIndex(section);
		if(index!=-1){
			return sections.remove(index);
		}
		return null;
	}
	
	public SectionDataEntry cutSection(int index){
		if(sections!=null){
			return sections.remove(index);
		}
		return null;
	}
	
	public void addClass(String className) {
//		content.addStyleName(className);
		classNames.add(className);
	}
	
	public void removeClass(String className) {
//		content.removeStyleName(className);
		classNames.remove(className);
	}

	public String getId() {
		return id;
	}

	public void setId(String id) {
		this.id = id;
	}

	public String getParentId() {
		return parentId;
	}

	public void setParentId(String parentId) {
		this.parentId = parentId;
	}

	public String getBehavior() {
		return behavior;
	}

	public void setBehavior(String behavior) {
		this.behavior = behavior;
	}
	
	public Type getType() {
		return type;
	}

	public void setType(Type type) {
		this.type = type;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public ArrayList<SectionDataEntry> getSections() {
		return sections;
	}

	public void setSections(ArrayList<SectionDataEntry> sections) {
		this.sections = sections;
	}

	public ArrayList<String> getClassNames() {
		return classNames;
	}

	public void setClassNames(ArrayList<String> classNames) {
		this.classNames = classNames;
	}

	public boolean isSelect() {
		return select;
	}

	public void setSelect(boolean select) {
		this.select = select;
	}

	
	
	
}
