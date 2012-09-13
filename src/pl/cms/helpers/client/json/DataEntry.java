package pl.cms.helpers.client.json;


import java.util.Date;

import com.google.gwt.json.client.JSONObject;
import com.google.gwt.json.client.JSONValue;

public class DataEntry {
	private String name;
	private JSONValue data;
	private Date lastUpdate = new Date();
	
	public DataEntry(String name, JSONValue jsonValue) {
		this.name = name;
		this.data = jsonValue;
	}
	
	public DataEntry(JSONObject o){
		JsonEntry je = new JsonEntry(o);
		String name = je.getJsonString("name");
		if(name!=null) setName(name);
		JSONValue data = je.getJsonValue("data");
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
