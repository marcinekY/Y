package pl.cms.helpers.client.json_test;

public class MyCallback {
		  public interface Function { 
		    void apply(int x, Object y); 
		  } 
		  public void methodWithPseudoFunctionParameter(Function func) { 
		    func.apply(1, new Object()); 
		  } 
		  public static void main(String[] args) { 
		    new MyCallback().methodWithPseudoFuntionParameter(new Function() { 
		      public void apply(int x, Object y) { 
		        System.out.println("From nested fucntion: " + x); 
		      } 
		    });
		  }
		private void methodWithPseudoFuntionParameter(Function function) {
			
		} 
}
