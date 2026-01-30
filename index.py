import random, config, json, sys

if __name__ != "__main__" : exit()

cmd = []
def greeting():
    print("""
  ______         ______                 _          
 |  ____|       |  ____|               (_)         
 | |__   _ __   | |__   _ __ ___  _ __  _ _ __ ___ 
 |  __| | '_ \  |  __| | '_ ` _ \| '_ \| | '__/ _ \\
 | |____| |_) | | |____| | | | | | |_) | | | |  __/
 |______| .__/  |______|_| |_| |_| .__/|_|_|  \___|
        | |                      | |               
        |_|                      |_|             

- {option} {text}      
""")

def check_command_line(argsv):
    global cmd
    try:
        argsv[1]
    except:
        greeting()
        return False

    t = False
    f = False
    o = False

    try:
        argsv.index("-t")
    except:
        t = True
    
    try:
        argsv.index("-o")
    except:
        o = True

    try:
        argsv.index("-f")
    except:
        f = True

    errors = 0
    if t == False: errors +=1
    if f == False: errors +=1
    if o == False: errors +=1


    if errors == 2:
        print("You Can Use One Option.")
        return False
    
    
    if t == False and argsv.index("-t") == 1:
        try:
            argsv[2]
        except:
            argsv.append("")

    if f == False and argsv.index("-f") == 1:
        try:
            argsv[2]
        except:
            argsv.append("")
    if f == False and argsv.index("-o") == 1:
        try:
            argsv[2]
        except:
            argsv.append("")
    
    cmd = argsv
    
def clean_cmd():
    cmd.pop(0)
    
    def clean(option):
        new_cmd = []

        loop_cmd = 0
        for command in cmd:
            if len(new_cmd) == 2: break

            if command == str(option) and loop_cmd == 0 or command == str(option) and loop_cmd != 0:
                new_cmd.insert(0, command)
                
            if command != str(option):
                new_cmd.insert(1, command)

            loop_cmd +=1

        return new_cmd
    
    t = False
    f = False
    o = False

    try:
        cmd.index("-t")
        t = True
    except:
        t = False
    
    try:
        cmd.index("-o")
        o = True
    except:
        o = False

    try:
        cmd.index("-f")
        f = True
    except:
        f = False


    if t == True :
        memory_cmd = clean("-t")
    elif o == True :
        memory_cmd = clean("-o")
    elif f == True:
        memory_cmd = clean("-f")
    
    return memory_cmd
        

        

class ace :

    keyEmpireJson = ""

    def __init__(self):
        self.keyEmpireJson = "{"
        for word in config.getSerialize():
            self.keyEmpireJson += f'"{str(config.getSerialize()[word])}": "{str(word)}"'
            if word != "9" : self.keyEmpireJson += ","
        self.keyEmpireJson += "}"

        self.keyEmpireJson = json.loads(self.keyEmpireJson)





    def encode(self, msg):
        return str(msg).encode("utf")
    
    def decode(self, msg):
        return str(msg).decode("utf")
    
    def isEncoded(self, msg):
        try:
            msg.decode()
            return True
        except (UnicodeDecodeError, AttributeError):
            return False
    
    def isInt(self, msg):
        try:
            msg = int(msg)
            msg = msg * 1

            if msg == "\\" or msg == "*" or msg == " ":
                return False
            return True
        except:
            return False
    
    def encodeEmpire(self, msg):
        if self.isEncoded(msg) == False: msg = self.encode(msg)
        syntax = ""

        for word in str(msg):
            try:
                syntax += config.getSerialize()[word]
            except (KeyError):
                syntax += word
        
        return syntax
    
    def decodeEmpire(self, msg):
        

        def llc(syntax):
            code = """
try:
    getBytes = {}.decode()
except:
    error = True
""".format(syntax)
            try:
                exec(code)
                return eval("getBytes")
            
                if eval(error == True):

                    print("[Encryption failed] The encryption code may be incomplete or the ID data does not belong to you")
                    exit()
            except:
                    print("[Encryption failed] The encryption code may be incomplete or the ID data does not belong to you")
                    exit()

        syntax = ""
        cashe = ""
        loop = 0
        for word in msg:

            try:
                if loop != 10 and self.isInt(word):
                    cashe += word
                    loop +=1
                
                if loop == 10 and self.isInt(word):
                    syntax += self.keyEmpireJson[cashe]
                    cashe = ""
                    loop = 0
                    
                elif self.isInt(word) != True:
                    syntax += word
            except:
                print("[Encryption failed] The encryption code may be incomplete or the ID data does not belong to you")
                exit()
        syntax = llc(syntax)
        return syntax

if check_command_line(sys.argv) == False:
    exit()

cmd = clean_cmd()


class runTool:

    def __init__(self):
        self.plugin = ace()

        if self.getOption() == "-o":
            self.uncryption()
        elif self.getOption() == "-t":
            self.encryption()
        elif self.getOption() == "-f":
            pass

    def getOption(self) -> str:
        return str(cmd[0])
    
    def getMessage(self) -> str:
        return str(cmd[1])

    def encryption(self):
        msg = self.getMessage()
        print(self.plugin.encodeEmpire(msg))
    
    def uncryption(self) -> str:
        msg = self.getMessage()
        print(self.plugin.decodeEmpire(msg))

runTool()
