package pl.cms.css.client.test;

import java.util.ArrayList;

import com.google.gwt.json.client.JSONArray;

import pl.cms.helpers.client.json_test.JsonEntry;

public class Property {
	private String name;
	private String type;
	private String parent;
	private ArrayList<String> values = new ArrayList<String>();
	private ArrayList<String> units = new ArrayList<String>();
	private String version;
	private JsonEntry data;
	
	public Property() {
		data = new JsonEntry();
	}
	
	public Property(JsonEntry data){
		this.data = data;
		init();
	}
	
	private void init(){
		name = data.getString("name");
		type = data.getString("type");
		parent = data.getString("parent");
		JSONArray v = data.getArray("values");
		if(v!=null){
			for (int i = 0; i < v.size(); i++) {
				String s = v.get(i).isString().stringValue();
				if(s!=null){
					values.add(s);
				}
			}
		}
	}

	public String getName() {
		return data.getString("name");
	}

	public void setName(String name) {
		
//		this.data.setValue("name", name);
	}

	public String getType() {
		return type;
	}

	public void setType(String type) {
		this.type = type;
	}

	public String getParent() {
		return parent;
	}

	public void setParent(String parent) {
		this.parent = parent;
	}

	public ArrayList<String> getValues() {
		return values;
	}

	public void setValues(ArrayList<String> values) {
		this.values = values;
	}

	public ArrayList<String> getUnits() {
		return units;
	}

	public void setUnits(ArrayList<String> units) {
		this.units = units;
	}

	public String getVersion() {
		return version;
	}

	public void setVersion(String version) {
		this.version = version;
	}

	public JsonEntry getData() {
		return data;
	}

	public void setData(JsonEntry data) {
		this.data = data;
	}
	
}
