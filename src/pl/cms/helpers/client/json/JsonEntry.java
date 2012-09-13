package pl.cms.helpers.client.json;

import com.google.gwt.json.client.JSONArray;
import com.google.gwt.json.client.JSONObject;
import com.google.gwt.json.client.JSONValue;
import com.google.gwt.user.client.Window;

public class JsonEntry {
	private JSONObject o;
	
	public JsonEntry(){}
	
	public JsonEntry(JSONObject o){
		this.o = o;
	}
	
	public void getDataObType(){
		JSONValue v = o.get("data");
		if(v!=null){
			if(v.isArray()!=null) Window.alert("array");
			else if(v.isBoolean()!=null) Window.alert("boolean");
			else if(v.isNull()!=null) Window.alert("null");
			else if(v.isNumber()!=null) Window.alert("number");
			else if(v.isObject()!=null) Window.alert("object");
			else if(v.isString()!=null) Window.alert("string");
		} else Window.alert("nothing");
	}
	
	public String getJsonString(String key) {
		if(o!=null){
			JSONValue v = o.get(key);
			if (v != null) {
				if (v.isString() != null) {
					return v.isString().stringValue();
				}
				if (v.isNumber() != null) {
					return v.isNumber().toString();
				}
			}
		}
		return null;
	}
	
	public JSONArray getJsonArray(String key) {
		if(o!=null){
			JSONValue v = o.get(key);
			if(v != null){
				return v.isArray();
			}
		}
		return null;
	}
	
	public JSONObject getJsonObject(String key){
		if(o!=null){
			JSONValue v = o.get(key);
			if(v!=null){
				return v.isObject();
			}
		}
		return null;
	}
	
	public JSONValue getJsonValue(String key) {
		JSONValue v = o.get(key);
		if (v != null) {
			return v;
		}
		return null;
	}
	
	protected String getJsonValue(JSONObject o, String key) {
		JSONValue v = o.get(key);
		if (v != null) {
			if (v.isString() != null) {
				return v.isString().stringValue();
			}
			if (v.isNumber() != null) {
				return v.isNumber().toString();
			}
		}
		return null;
	}

	public JSONObject getO() {
		return o;
	}

	protected void setO(JSONObject o) {
		this.o = o;
	}
}
