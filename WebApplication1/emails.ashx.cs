using Common.DataAccess;
using System;
using System.Collections.Generic;
using System.Data;
using System.Globalization;
using System.Linq;
using System.ServiceModel.Syndication;
using System.Web;

namespace WebApplication1
{
    /// <summary>
    /// Summary description for emails
    /// </summary>
    public class emails : IHttpHandler
    {

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/xml";

            SyndicationFeed myFeed = new SyndicationFeed();
            myFeed.Title = new TextSyndicationContent("InvestHype");
            DateTimeFormatInfo dfi = DateTimeFormatInfo.CurrentInfo;
            Calendar cal = dfi.Calendar;

            int week = cal.GetWeekOfYear(DateTime.Now, dfi.CalendarWeekRule, dfi.FirstDayOfWeek);
            myFeed.Description = new TextSyndicationContent("De hetaste finansnyheterna just nu!");
            myFeed.Language = "Swedish/Svenska";
            List<SyndicationItem> feedItems = new List<SyndicationItem>();
            IDBOperator idb = DBOperator.GetInstance();
            string sql = "SELECT  id, address, sent, date FROM email where sent < 1 ORDER BY id DESC LIMIT 10;";
            DataTable dt = idb.ReturnDataTable(sql);
            if (dt.Rows.Count > 0)
            {
                for (int i = 0; i < dt.Rows.Count; i++)
                {
                    string id = dt.Rows[i]["id"].ToString();
                    int sent = (int)dt.Rows[i]["sent"];
                    sent++;
                    SyndicationItem item = new SyndicationItem();
                    SyndicationPerson authInfo = new SyndicationPerson();
                    SyndicationLink link = new SyndicationLink(new Uri("http://investhype.com/xtranet-files/Teckningssedel.pdf"));
                    authInfo.Name = dt.Rows[i]["address"].ToString();
                    DateTime date = (DateTime)(dt.Rows[i]["date"]);
                    item.PublishDate = new DateTimeOffset(date);
                    item.Title = new TextSyndicationContent("Xtranets nyemsission");
                    item.Summary = new TextSyndicationContent("Hej,<br/><br/>Tack för visat intresse i Xtranet. <br/><br/>" +
                        "Bifogat finner du teckningssedel samt länk till memorandum och teaser. <br/><br/>" +
                        "Länk till:<br/>" +
                        "<a href='http://investhype.com/xtranet-files/Xtranet_Memorandum.pdf'>Memorandum</a><br/>" +
                        "<a href='http://investhype.com/xtranet-files/Xtranet_Teaser.pdf'>Teaser</a><br/><br/>" +
                        "För att ta del av nyemissionen fyll i och skicka in din teckningssedel.<br/><br/>" +
                        "Mvh,<br/>" +
                        "Oliver Molse<br/>" +
                        "Oliver@InvestHype.com<br/>" +
                        "VD InvestHype");
                    
                    item.Links.Add(link);
                    item.Authors.Add(authInfo);
                    feedItems.Add(item);

                    if(i == 0){
                        myFeed.LastUpdatedTime = date;
                    }
                    string update = "UPDATE email SET sent=" + sent + " where id=" + id + ";";
                    idb.ExeCmd(update);

                }
            }

            myFeed.Items = feedItems;
           

            System.Xml.XmlWriter writer = XmlCDataWriter.Create(context.Response.Output);
            myFeed.SaveAsAtom10(writer);
            writer.Close();
        }

        public bool IsReusable
        {
            get
            {
                return false;
            }
        }
    }
}