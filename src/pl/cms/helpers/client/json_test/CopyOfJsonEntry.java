package pl.cms.helpers.client.json_test;

import com.google.gwt.json.client.JSONArray;
import com.google.gwt.json.client.JSONObject;
import com.google.gwt.json.client.JSONValue;

public class CopyOfJsonEntry {
	private JSONObject o;
	
	public CopyOfJsonEntry(){}
	
	public CopyOfJsonEntry(JSONObject o){
		this.o = o;
	}
	
//	public void alertDataObType(){
//		JSONValue v = o.get("data");
//		if(v!=null){
//			if(v.isArray()!=null) Window.alert("array");
//			else if(v.isBoolean()!=null) Window.alert("boolean");
//			else if(v.isNull()!=null) Window.alert("null");
//			else if(v.isNumber()!=null) Window.alert("number");
//			else if(v.isObject()!=null) Window.alert("object");
//			else if(v.isString()!=null) Window.alert("string");
//		} else Window.alert("nothing");
//	}
	
	public String getJSONString(String key) {
		JSONValue v = getJSONValue(key);
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
	
	public JSONArray getJSONArray(String key) {
		
		JSONValue v = getJSONValue(key);
		if(v != null) return v.isArray();
		return null;
	}
	
	public JSONObject getObject(String key){
		JSONValue v = getJSONValue(key);
		if(v!=null) return v.isObject();
		return null;
	}
	
	public JSONValue getJSONValue(String key) {
		if(o!=null){
			JSONValue v = o.get(key);
			return v;
		}
		return null;
	}
	
//	protected String getJsonString(JSONObject o, String key) {
//		JSONValue v = o.get(key);
//		if (v != null) {
//			if (v.isString() != null) {
//				return v.isString().stringValue();
//			}
//			if (v.isNumber() != null) {
//				return v.isNumber().toString();
//			}
//		}
//		return null;
//	}
	
	public JSONValue setValue(String key,JSONValue jsonValue){
		return this.o.put(key, jsonValue);
	}

	public JSONObject getO() {
		return o;
	}

	protected void setO(JSONObject o) {
		this.o = o;
	}
}
