package pl.cms.helpers.client.json;

public class Token {
	String token;
	String index;
	String value;
	
	public Token(){
		this.token = com.google.gwt.user.client.Window.Location.getHash();
		if(!token.equals("")){
			if(token.substring(0, 1).equals("#")) token = token.substring(1);
			String[] tmp = token.split(":");
			setIndex(tmp[0]);
			if(tmp.length>1) setValue(tmp[1]);
			
		}
	}
	
	public Token(String token){
		if(!token.equals("")){
			if(token.substring(0, 1).equals("#")) token = token.substring(1);
			String[] tmp = token.split(":");
			setIndex(tmp[0]);
			if(tmp.length>1) setValue(tmp[1]);
			setToken(getIndex()+":"+getValue());
		}
	}

	public String getToken() {
		return token;
	}

	public void setToken(String token) {
		this.token = token;
	}

	public String getIndex() {
		return index;
	}

	public void setIndex(String index) {
		this.index = index;
	}

	public String getValue() {
		return value;
	}

	public void setValue(String value) {
		this.value = value;
	}
	
	
}
