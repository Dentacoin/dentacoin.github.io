/// <summary>
/// A simple object that holds a list of deserialized MailChimp List Members.
/// </summary>
public class ListMembers
{
    public List<ListMember> members { get; set; }
}

/// <summary>
/// A simple object that holds a single deserialized MailChimp List Member.
/// </summary>
public class ListMember
{
    public string email_address { get; set; }
}

private ListMembers GetListMembers(string dataCenter, string apiKey, string listId)
{
    var result = new ListMembers { members = new List<ListMember>() };

    long offset = 0;
    const int numberPerBatch = 500; // count parameter.

    var uri = string.Format("https://{0}.api.mailchimp.com/3.0/lists/{1}/members?offset={2}&count={3}",
        dataCenter, listId, offset, numberPerBatch);

    try
    {
        while (true)
        {
            using (var webClient = new WebClient())
            {
                webClient.Headers.Add("Accept", "application/json");
                webClient.Headers.Add("Authorization", "apikey " + apiKey);

                var responseJson = webClient.DownloadString(uri);
                var responseListMembers = JsonConvert.DeserializeObject<ListMembers>(responseJson);

                if (responseListMembers.members != null)
                {
                    // Add members returned from current batch into result list.
                    result.members.AddRange(responseListMembers.members);
                }

                // When the number of members returned in this batch is less than batch size,
                // break out of the loop, as it means this is the last batch.
                if (responseListMembers.members.Count < numberPerBatch)
                {
                    break;
                }
            }
            offset += (long) numberPerBatch;
        }
        return result;
    }
    catch (WebException we)
    {
        using (var sr = new StreamReader(we.Response.GetResponseStream()))
        {
            Console.WriteLine(sr.ReadToEnd());
            throw;
        }
    }
}