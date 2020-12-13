import requests
from bs4 import BeautifulSoup
from threading import Thread
from time import sleep
headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36'
}


def file_generator(link, headers):
    res = requests.get(
        "https://www.medicinenet.com/reduction_of_radial_head_dislocation/article.htm", headers=headers)
    soup = BeautifulSoup(res.text, 'lxml')
    file_name = soup.select('h1')[0].text
    txt = ''
    try:
        soup.find('div', {"class": "from_webmd"}).decompose()
    except:
        pass
    for wrap in soup.find_all("div", {"class": "apPage"}):
        for lst in wrap.find_all("div", {"class": "wrapper"}):
            txt = txt+lst.text+" "

    txt = ' '.join(x.strip() for x in txt.strip().split())
    forbidden = ['\\', '/', ':', '*', '\'',
                 '<', '>', '|', '.', '-', '\"', '&', '?']
    file_name = list(file_name)
    for i in file_name:
        if i in forbidden:
            file_name.remove(i)
    file_name = "".join(file_name)

    with open(file_name.strip()+".txt", "w", encoding='utf-8') as f:
        f.write(txt)


lst = set()
base_url = "https://www.medicinenet.com/diseases_and_conditions/alpha_"
main_url = "https://www.mayoclinic.org/"
for i in range(97, 123):
    res = requests.get(
        "https://www.medicinenet.com/diseases_and_conditions/alpha_"+chr(i)+".htm", headers=headers)
    soup = BeautifulSoup(res.text, 'lxml')
    links = soup.find("div", {"id": "AZ_container"}).find_all("li")
    for link in links:
        if link.a['href'] not in lst:
            lst.add(link.a['href'])
            t = Thread(target=file_generator, args=(link.a['href'], headers))
            t.start()
        break
    break
    sleep(10)

lst = list(lst)
print(lst[0])
print(len(lst))
print(len(set(lst)))
