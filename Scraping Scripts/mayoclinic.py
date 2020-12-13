import requests
from bs4 import BeautifulSoup
from threading import Thread
from time import sleep

headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36'
}


def file_generator(link, headers):
    res = requests.get(link, headers=headers)
    soup = BeautifulSoup(res.text, 'lxml')
    file_name = soup.select('h1')[0].text
    lst = soup.find("div", {"class": "content"}).find(
        "div", {"class": None}).contents
    txt = ''

    for i in lst:
        if i.string:
            txt = txt+i.string+" "
        else:
            txt = txt+i.text+" "

    txt = ' '.join(x.strip() for x in txt.strip().split())
    forbidden = ['\\', '/', ':', '*', '\'',
                 '<', '>', '|', '.', '-', '\"', '&', '?']

    file_name = list(file_name)
    for i in file_name:
        if i in forbidden:
            file_name.remove(i)
    file_name = "".join(file_name)

    with open(file_name+".txt", "w", encoding='utf-8') as f:
        f.write(txt)


lst = set()

base_url = "https://www.mayoclinic.org/diseases-conditions/index?letter="
main_url = "https://www.mayoclinic.org/"
for i in range(65, 91):
    res = requests.get(
        base_url+chr(i), headers=headers)
    soup = BeautifulSoup(res.text, 'lxml')
    links = soup.find("div", {"id": "index"}).find('ol').find_all('a')
    for link in links:
        complete_url = (requests.compat.urljoin(main_url, link["href"]))
        if complete_url not in lst:
            lst.add(complete_url)
            t = Thread(target=file_generator, args=(complete_url, headers))
            t.start()
    sleep(1)

lst = list(lst)
print(lst[0])
print(len(lst))
print(len(set(lst)))
