package pl.cms.helpers.client.json;

import java.util.ArrayList;

import pl.cms.helpers.client.var.Value;

public class UrlEntry {
	private String url;
	private ArrayList<Value> values = new ArrayList<Value>();
	private String path = "getData.php";
	
	public UrlEntry(){
	}
	
	public UrlEntry(String path){
		setPath(path);
	}

	public String getUrl() {
		url = path;
		if(values.size()>0) url += "?";
		for (int i = 0; i < values.size(); i++) {
			url += values.get(i).getName()+"="+values.get(i).getValue().toString();
		}
		return url;
	}
	
	public void addValue(String name,Object value){
		values.add(new Value(name, value));
	}
	
	public void clearValues(){
		values.clear();
	}

	public void setUrl(String url) {
		this.url = url;
	}

	public ArrayList<Value> getValues() {
		return values;
	}

	public void setValues(ArrayList<Value> values) {
		this.values = values;
	}

	public String getPath() {
		return path;
	}

	public void setPath(String path) {
		this.path = path;
	}
}
