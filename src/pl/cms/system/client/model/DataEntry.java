package pl.cms.system.client.model;


import java.util.Date;

import pl.cms.helpers.client.json_test.JsonEntry;

import com.google.gwt.json.client.JSONObject;
import com.google.gwt.json.client.JSONValue;

public class DataEntry {
	private String name;
	private JSONValue data;
	private Date lastUpdate = new Date();
	
	public DataEntry(String name, JSONValue jsonValue) {
		if(name!=null) setName(name);
		if(jsonValue!=null) setData(jsonValue);
	}
	
	public DataEntry(JSONObject o){
		JsonEntry je = new JsonEntry(o);
		String name = je.getString("name");
		if(name!=null) setName(name);
		JSONValue data = je.getValue("data");
		if(data!=null) setData(data);
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public JSONValue getData() {
		return data;
	}

	public void setData(JSONValue data) {
		this.data = data;
	}

	public Date getLastUpdate() {
		return lastUpdate;
	}

	public void setLastUpdate(Date lastUpdate) {
		this.lastUpdate = lastUpdate;
	}
}
